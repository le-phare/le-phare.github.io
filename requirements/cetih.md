---
layout: hidden
title: Hosting requirements CETIH
version: 1.2
---

## Hardware requirements (per app)

  - CPU >= 2 core
  - RAM >= 4GB
  - Project Storage >= 40GB

## Recommanded Operating System

  - Last stable [Debian](https://www.debian.org) (currently Debian Stretch)

## Software requirements

  - PHP >= 7.1 recommended
  - Apache = 2.4
  - PostgreSQL >= 9.6
  - Memcached
  - git
  - [git-lfs](https://git-lfs.github.com/)
  - curl
  - crontab
  - [Elasticsearch](https://www.elastic.co/fr/products/elasticsearch) >= 6.2
  - [Kibana](https://www.elastic.co/fr/products/kibana) >= 6.2
  - [RabbitMQ](https://www.rabbitmq.com/) >= 3.6
  - Supervisor >= 3.3.2
  - [adminer](https://www.adminer.org/)
  - [ghostscript](https://www.ghostscript.com/) >= 9.06

### PHP extensions

  - ctype
  - curl
  - gd
  - iconv
  - intl
  - json
  - mbstring
  - pdo
  - pdo-pgsql
  - pgsql
  - posix
  - tokenizer
  - xml
  - opcache
  - mbstring
  - memcached
  - imagick
  - ssh2
  - apcu
  - apcu-bc

### PHP settings

```ini
short_open_tag = Off
magic_quotes_gpc = Off
register_globals = Off
session.autostart = Off
date.timezone = Europe/Paris
upload_max_filesize = 32M
post_max_size = 33M
```

#### Memcached Settings

PHP sessions stored in **memcached**.

```ini
session.save_handler = memcached
session.save_path = localhost:11211
memcached.sess_lock_wait_min = 150
memcached.sess_lock_wait_max = 150
memcached.sess_lock_retries = 800
```

#### OPcache Settings

```ini
opcache.revalidate_freq=0
opcache.validate_timestamps=0
opcache.max_accelerated_files=7963
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.fast_shutdown=1
```

#### Notes

### Apache modules

  - mod_rewrite On
  - mod_headers On
  - mod_expires On
  - mod_deflate On

### Apache configuration

```apache
Options FollowSymLinks
AllowOverride AuthConfig Limit FileInfo Indexes Options=Indexes,FollowSymLinks
```

#### Recommended configuration

```apache
ServerSignature Off
ServerTokens Prod
```

## System requirements

  - SSH :
    - Allow key authentification
    - Allow agent forwarding
  - logrotate on `shared/var/logs/*.log`
  - Apache `DOCUMENT_ROOT` on `current/web/`
  - access to Apache logs
  - crontab enabled and managable by the system user
  - user shell set to `/bin/bash`

## Network requirements

  - Allow smtp output
  - all domains MUST be accessible through HTTPS
  - HTTP/2 SHOULD be enabled

### SSH inputs

  - 212.198.41.172
  - 109.190.225.66
  - 37.59.114.65

### SSH outputs

  - github.com (beware of their [ip range](https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist))
  - bitbucket.org
  - gitlab.com

### HTTP/HTTPS output

  - github.com ([IP range](https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist))
  - bitbucket.org ([IP list](https://blog.bitbucket.org/2015/12/03/making-bitbuckets-network-better-faster-and-ready-to-grow))
  - gitlab.com
  - packagist.org
  - packagist.com
  - getcomposer.org
  - api.rollbar.com
  - faros.lephare.com

### SSH Keys

```shell
curl -sL https://faros.lephare.com/lephare.keys >> ~/.ssh/authorized_keys
chmod 0600 ~/.ssh/authorized_keys
```
