---
layout: default
title: Accueil
nav_order: 1
description: "Informations techniques"
permalink: /
currentMenu: accueil
redirect_from: /requirements/
---

# Pré-requis hébergements
{: .fs-9 }

Ce site présente les configurations nécessaires à l'hébergement des projets réalisés au Phare.
{: .fs-6 .fw-300 }

[Configuration commune](/configuration){: .btn .btn-primary .fs-5 .mb-4 .mb-md-0 .mr-2 } [Dernière version](/docs/versions/2024.07){: .btn .fs-5 .mb-4 .mb-md-0 }

---

## Changements

### 2024-07-19

* version 2024.07: upgrade PostgreSQL vers la version 16

### 2024-07-16

* Ajout de la version 2024.07 (version de Python entre 3.7 et 3.12)

### 2024-07-05
* Ajout de [l'extension Apache Brotli](https://httpd.apache.org/docs/current/mod/mod_brotli.html) aux prérequis
* Compression des fichiers textuels avec Brotli dans Apache

### 2024-04-16

* Ajout de la version 2024.04 (Symfony 7, PHP 8.3, timezone UTC)
* Suppression de bitbucket.org et gitlab.lephare.io des flux réseaux

### 2023-10-06

* suppression flux `gitlab.lephare.io` des [flux réseaux](/docs/config/network.html).
* ajout flux `api.pwnedpasswords.com` des [flux réseaux](/docs/config/network.html).

### 2023-10-02

* ajout binaire "python" dans la configuration commune.
* correction quant à la mention du binaire "rsync" dans la configuration commune. Il est utilisé par `lephare/ansible-deploy` depuis le control node. En revanche, il reste pertinent de l'installer sur un serveur pour échanger des fichiers.

### 2023-09-29

* ajouts des sections "Droits" et "Logs"

### 2023-09-22

* ajout binaire pg_dump

### 2023-07-05

* Suppression de l'extension php apcu-bc des prérequis (non compatible PHP 8)

### 2023-06-14

* Ajout de la version 2023.06

### 2023-04-28

* Ajout de la version 2023.04

### 2022-07-01

* Ajout de la version 2022.07
* Modification de la configuration pour suivre les dernières recommandations de symfony

### 2021-03-17

* Ajout version 10.1 accompagnée d' un script qui check une bonne partie des prérequis
* Corrections mineures de la version 10.0

### 2019-10-18

 * Ajout dimensionnement minimum de machine : 2 vCPU et 4G RAM

### 2019-10-03

 * Ajout version Debian 10

### 2019-05-16

 * Suppression extension php ssh2 non compatible avec php 7.3

### 2019-03-28

 * Publication des nouveaux pré-requis
