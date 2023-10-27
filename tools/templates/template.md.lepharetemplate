---
layout: default
title: {{version}}
nav_order: {{order_in_list}}
parent: Versions
---
<div class="callout callout-info" markdown="span">
Pour être sur que la machine est bien configurée --> tout en vert sur le script PHP, toutes les caches sur ce document cochées.
</div>

# {{version}}

- <input type="checkbox"/> Debian {{debian_version}}
- <input type="checkbox"/> PHP {{php_version}}
- <input type="checkbox"/> Apache {{apache_version}}
- <input type="checkbox"/> PostgreSQL {{pgsql_version}}

## Check

<input type="checkbox"/> Le script [check_{{version}}.php](../versions_tests_scripts/check_{{version}}.php) est à disposition pour check une bonne partie des prérequis.
Tous les voyants devraient être verts, attention cependant il est possible d'avoir de faux négatifs (par exemple si la mémoire configurée est supérieure à celle requise).

# Configuration de base
{: .no_toc }

1. TOC
{:toc}

## Dimensionnement machine

Nous exigeons au minimum :
 * <input type="checkbox"/> {{expected_vcpus}} vCPU
 * <input type="checkbox"/> {{expect_ram_go}}Go RAM

## Authentification SSH

<input type="checkbox"/> La liste des clés publiques des utilisateurs du Phare est disponible à l'adresse suivante : [https://faros.lephare.com/lephare.keys].

	curl -sL https://faros.lephare.com/lephare.keys >> ~/.ssh/authorized_keys
	chmod 0600 ~/.ssh/authorized_keys

<input type="checkbox"/> La liste des adresses ips à autoriser : 
{{ip_to_authorize}}


## Binaires
{{binaries_to_display}}


## Droits

### Logs

Créer un user séparé qui a uniquement accès en lecture aux fichiers de logs suivants :

- <input type="checkbox"/>Apache access.log
- <input type="checkbox"/>Apache error.log
- <input type="checkbox"/>PHP-FPM log

## Configuration PHP

### Extensions

Pré-requis pour Symfony 6.x

 {{symfony_requirements}}

Extensions supplémentaires pour nos applications
 {{faros_requirements}}

### php.ini
{{settings}}

## Configuration Apache

### <input type="checkbox"/> SSL & HTTP/2

Chaque vhost doit être accessible en HTTPS et HTTP/2.

### <input type="checkbox"/> Configuration vhost

	DocumentRoot <deploy_dir>/current/public/
	Options FollowSymLinks
	Protocols h2 http/1.1

### Modules

- <input type="checkbox"/> mod_rewrite On
- <input type="checkbox"/> mod_headers On
- <input type="checkbox"/> mod_expires On
- <input type="checkbox"/> mod_deflate On


<style>.callout.callout-info {
  background-color: #3498db; /* Couleur de fond bleue */
  color: #fff; /* Couleur du texte en blanc */
  border-left: 5px solid #2980b9; /* Bordure gauche bleue plus foncée */
  padding: 10px; /* Espace intérieur */
  margin: 10px 0; /* Marge extérieure */
  border-radius: 5px; /* Coins arrondis */
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Ombre légère */
}

.callout.callout-info p {
  margin: 0; /* Supprime la marge du texte à l'intérieur du callout */
}
</style>