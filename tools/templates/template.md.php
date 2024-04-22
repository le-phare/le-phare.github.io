<?php if (!$versionData) {
    exit(84);
} // 0.6 // @phpstan-ignore-line?>
---
layout: default
title: <?php echo $versionData->fullVersionName; ?>

nav_order: <?php echo $versionData->order_in_list; ?>

parent: Versions
permalink: docs/versions/<?php echo $versionData->version; ?>.html

---
<div class="callout callout-info" markdown="span">
Pour être sûr que la machine est bien configurée --> tout doit être en vert sur le script PHP, toutes les checkbox sur ce document cochées.
</div>

# <?php echo $versionData->version; ?>


1. TOC
{:toc}

## Check

<input type="checkbox"/> Le script [check_<?php echo $versionData->version; ?>.php](../versions_tests_scripts/check_<?php echo $versionData->version; ?>.php) est à disposition pour check une bonne partie des prérequis.
Tous les voyants devraient être verts, attention cependant il est possible d'avoir de faux négatifs (par exemple si la mémoire configurée est supérieure à celle requise).

## La stack de base
- <input type="checkbox"/> Debian <?php echo $versionData->debian_version; ?>

- <input type="checkbox"/> PHP <?php echo $versionData->php_version; ?>

- <input type="checkbox"/> Apache <?php echo $versionData->apache_version; ?>

- <input type="checkbox"/> PostgreSQL <?php echo $versionData->pgsql_version; ?>


## Dimensionnement machine

Nous exigeons au minimum :
 * <input type="checkbox"/> <?php echo $versionData->expected_vcpus; ?> vCPU
 * <input type="checkbox"/> <?php echo $versionData->expected_ram_go; ?> Go RAM

## Authentification SSH

<input type="checkbox"/> La liste des clés publiques des utilisateurs du Phare est disponible à l'adresse suivante : [https://faros.lephare.com/lephare.keys](https://faros.lephare.com/lephare.keys).

	curl -sL https://faros.lephare.com/lephare.keys >> ~/.ssh/authorized_keys
	chmod 0600 ~/.ssh/authorized_keys

<input type="checkbox"/> La liste des adresses ips à autoriser :
<?php
  foreach ($versionData->ip_to_authorize as $ip) {
      echo '* '.$ip." \n";
  }
?>


## Binaires
<?php
  foreach ($versionData->binaries_to_display as $bin) {
      echo '* <input type="checkbox"/> '.$bin." \n";
  }
?>


## Droits

### Logs

Créer un user séparé qui a uniquement accès en lecture aux fichiers de logs suivants :

- <input type="checkbox"/> Apache access.log
- <input type="checkbox"/> Apache error.log
- <input type="checkbox"/> PHP-FPM log

## Configuration PHP

### Extensions

Pré-requis pour Symfony 7.x

<?php
  foreach ($versionData->symfony_requirements as $requirement) {
      if ('_' == $requirement[0]) {
          $requirement = substr($requirement, 1);
      }
      echo '* '.$requirement." \n";
  }
?>

Extensions supplémentaires pour nos applications
<?php
  foreach ($versionData->faros_requirements as $requirement) {
      if ('_' == $requirement[0]) {
          $requirement = substr($requirement, 1);
      }
      echo '* '.$requirement." \n";
  }
?>

### php.ini
<?php
  foreach ($versionData->settings as $key => $value) {
      if ('_' != substr($key, 0, 1)) {
          if ('<' == $value[0] || '>' == $value[0]) {
              if ('=' == $value[1]) {
                  $value = substr($value, 2);
              } else {
                  $value = substr($value, 1);
              }
          }
          echo "\t".$key.' = '.$value."\n";
      } else {
          echo "\t".$value."\n";
      }
  }
?>

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


<style>
.callout.callout-info {
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

## Configuration PostgreSQL

L'utilisateur doit avoir les privilèges "CREATE" sur le schéma public.
