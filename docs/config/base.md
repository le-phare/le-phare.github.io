---
layout: default
title: Configuration
nav_order: 2
permalink: /configuration
has_children: true
---

# Configuration de base
{: .no_toc }

1. TOC
{:toc}

## Authentification SSH 

La liste des clés publiques des utilisateurs du Phare est disponible à l'adresse suivante : https://faros.lephare.com/lephare.keys.

	curl -sL https://faros.lephare.com/lephare.keys >> ~/.ssh/authorized_keys
	chmod 0600 ~/.ssh/authorized_keys

La liste des adresses ips à autoriser : 
 * 212.198.41.172
 * 109.190.225.66
 * 37.59.114.65

## Binaires 

 - git
 - curl

## Configuration PHP

### Extensions

 * ctype
 * curl
 * gd
 * iconv
 * intl
 * json
 * mbstring
 * pdo
 * pdo-pgsql
 * pgsql
 * posix
 * tokenizer
 * xml
 * opcache
 * memcached
 * imagick
 * apcu
 * apcu-bc
 * exif
 * zip
 * soap

### php.ini

	short_open_tag = Off
	magic_quotes_gpc = Off
	register_globals = Off
	session.autostart = Off
	date.timezone = Europe/Paris
	upload_max_filesize = 32M
	post_max_size = 33M
	sys_temp_dir = /var/tmp
	upload_dir = /var/tmp

	# Les sessions sont stockées dans memcached
	session.save_handler = memcached
	session.save_path = localhost:11211
	memcached.sess_lock_wait_min = 150
	memcached.sess_lock_wait_max = 150
	memcached.sess_lock_retries = 800

	# Optimisation Opcache
	opcache.revalidate_freq=0
	opcache.validate_timestamps=0
	opcache.max_accelerated_files=7963
	opcache.memory_consumption=192
	opcache.interned_strings_buffer=16
	opcache.fast_shutdown=1

## Configuration Apache

### SSL & HTTP/2

Chaque vhost doit être accessible en HTTPS et HTTP/2.

### Configuration vhost

	DocumentRoot <deploy_dir>/current/web/
	Options FollowSymLinks
	Protocols h2 http/1.1

### Modules

   * mod_rewrite On
   * mod_headers On
   * mod_expires On
   * mod_deflate On