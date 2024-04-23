---
layout: default
title: Tutoriel fichier de check
nav_order: 5
permalink: /check-tutorial
---

# Introduction

Pour garantir le bon fonctionnement de notre application dans différentes configurations PHP, nous fournissons deux versions de fichiers de test : une pour une exécution en ligne de commande (CLI) et une autre pour un déploiement via un serveur web (FPM).


## Avant de lancer les tests

Avant de lancer les tests, assurez-vous de modifier vos codes PostgreSQL dans le fichier de tests pour refléter votre configuration. De plus, assurez-vous que la base de données est active et accessible.

Voici un exemple de zone à éditer dans le fichier de test pour configurer la connexion à la base de données PostgreSQL :

```php
// Modifier ces informations pour correspondre à votre configuration PostgreSQL
$dbHost = 'localhost';
$dbServerName = '5432';
$dbUser = 'votre_nom_utilisateur';
$dbPassword = 'votre_mot_de_passe';
$dbPort = 'nom_de_votre_base_de_données';
```

## Lancer les tests depuis une ligne de commande

Les tests en CLI vérifient la configuration de l'installation, plus précisément une configuration de votre PHP qui sera faite pour les lignes de commandes.

### Exécution

```shell
php votre_fichier
```

### Résultats attendus

Voici la forme des résultats que vous allez obtenir avec le lancement de la commande.

[![asciicast](https://asciinema.org/a/90q17bv4Ov2bn8DXp6WpLySIS.svg)](https://asciinema.org/a/90q17bv4Ov2bn8DXp6WpLySIS)

## Lancer les tests depuis le serveur web

Depuis le serveur web, une partie des tests sont les mêmes que pour la ligne de commande, une autre vérifie la configuration Apache de votre installation.

### Exécution

Affichez votre fichier de tests depuis votre serveur web.

```
http://localhost:8080/tests/check.php
```
### Résultats attendus

Voici la forme des résultats que vous allez obtenir depuis votre serveur web.

![Test depuis un site](static/images/web_check.png)
