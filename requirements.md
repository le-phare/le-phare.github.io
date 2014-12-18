---
layout: page
title: Hosting requirements
---

## Hardware requirements

 * CPU >= 2 core
 * RAM >= 2GB
 * Project Storage >=20GB

## Recommanded Operating System

 * Linux Debian Wheezy (>=7.0)

## Software requirements

 - PHP >= 5.4.1
 - Apache >= 2.2
 - MySQL >= 5.5
 - git
 - curl

### PHP extensions

   * apc >= 3.0.17
   * ctype
   * curl
   * gd
   * iconv
   * intl
   * json
   * mbstring
   * pdo
   * pdo-mysql
   * posix
   * tokenizer
   * xml

### PHP settings

{% highlight ini %}
short_open_tag = Off
magic_quotes_gpc = Off
register_globals = Off
session.autostart = Off
date.timezone = Europe/Paris
{% endhighlight %}

### APC settings (system wide)

{% highlight ini %}
apc.shm_size=512M
{% endhighlight %}

### APC settings (vhost)

{% highlight ini %}
apc.enable_cli = 0
apc.num_files_hint=7000
apc.user_entries_hint=4096
apc.stat=0
apc.ttl=3600
apc.user_ttl=3600
{% endhighlight %}

### PHP/APC configuration

The APC opcode cache is shared between all child process of the master process. So to avoid cache collision we need a **master process per vhost**.

### Apache modules

   * mod_rewrite On
   * mod_headers On
   * mod_expires On
   * mod_deflate On

### Apache configuration

Options FollowSymLinks

## System requirements

 - SSH :
   * Allow key authentification
   * Allow agent forwarding
 - logrotate on shared/app/logs/prod.log
 - Apache DOCUMENT_ROOT on current/web/
 - crontab enabled and managable by the system user
 - access to Apache log
 - user shell set to /bin/bash

## Network requirements

 * Allow smtp output

### SSH inputs

 * 82.127.123.95
 * 212.198.41.172
 * 81.220.58.104

### SSH outputs

 * github.com (beware of their [ip range](https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist))
 * bitbucket.org

### HTTP/HTTPS output

 * github.com (beware of their [ip range](https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist))
 * bitbucket.org
 * packagist.org
 * toran.lephare-systeme.com
 * getcomposer.org
 * v2.lephare-systeme.com

### SSH ~/.ssh/authorized_keys

    ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDjmQLp9ANaDEX0u0awszEKK/ht5Kokyn6NZYqNjXt8hd3Hu91QXbAie9/jHotZIulIdlny30JuUGYzmoQ5UgAwBXIZmCzryyPT9INA32vlgIyvsC+6dj3YDH7WmFkDQyqxhKGgp5BHqb04F4IVJLO38qfCSOmBOJCyKtwEEA+PhICu1nlu7zENMUYzIZtZPL7lwWixSpTQuzFoSRjI5PkaK/SVSvct7BgFLHplcdSSDb769U7m62Lgwzzx5YBJwScECxJsyjXVKdWLGgvBPObxw4eML1K4LEnNQcz+zNkI6Bd+hfqubZcoS1TuGi9W+c8Mv6LYYe0lIA2IQaGwH4Zr dev@lephare.com
