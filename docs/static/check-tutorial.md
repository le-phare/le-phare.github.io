---
layout: default
title: Tutoriel fichier de check
nav_order: 5
permalink: /check-tutorial
---

# Lancement des tests

Les fichiers de test possèdent deux versions qui permettent de vérifier différentes configurations de PHP : une en ligne de commande (CLI) et une autre depuis un serveur web (FPM).

## Lancement des tests depuis une ligne de commande

Le lancement des tests en CLI vont vérifier la configuration de l'installation, plus précisément une configuration de votre PHP qui sera faite pour les lignes de commandes.

### Exécution

```shell
php votre_fichier
```

### Résultats attendus

Voici la forme des résultats que vous allez obtenir avec le lancement de la commande.

![Test depuis une ligne de commande](static/images/cli_check.png)

![Total des résultats dans la ligne de commande](static/images/cli_check_total.png)

## Lancement des tests depuis un site internet

Depuis le site internet, il y aura des tests de configuration qui seront les mêmes que pour la ligne de commande, mais avec d'autres tests qui vérifieront la configuration Apache de votre installation.

### Exécution

Affichez votre fichier de tests depuis votre serveur web.

### Résultats attendus

Voici la forme des résultats que vous allez obtenir depuis votre serveur web.

![Test depuis un site](static/images/web_check.png)
