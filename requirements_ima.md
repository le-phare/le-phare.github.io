---
layout: hidden
title: Hosting requirements
---

## Hardware requirements

 * CPU = 4 core
 * RAM = 4 GB
 * Project Storage = 100 GB

## Recommanded Operating System

 * Linux Debian Wheezy

## Software requirements

 - PHP = 5.5
 - Apache = 2.2
 - MySQL = 5.5
 - git : Command for installation : sudo apt-get install git
 - curl

How to install PHP 5.5 on Wheezy: 
  - Edit : /etc/apt/sources.list
  - Add this lines :

```    
#php 5.5
deb http://packages.dotdeb.org wheezy-php55 all
deb-src http://packages.dotdeb.org wheezy-php55 all
```

 - Udpate sources : sudo apt-get update
 - Install package : sudo apt-get install php5
 - Verify installation package : php -v (it should return PHP 5.5.X)

### PHP extensions

   * ctype
   * curl : Command for installation : sudo apt-get install curl php5-curl
   * gd : Command for installation : sudo apt-get install php5-gd
   * imagick : Command for installation : sudo apt-get install php5-imagick
   * iconv
   * intl : Command for installation : sudo apt-get install php5-intl
   * json : Command for installation : sudo apt-get install php5-common 
   * mbstring
   * pdo : Command for installation : sudo apt-get install php5-mysql
   * pdo-mysql
   * posix
   * tokenizer
   * xml
   
### PHP settings

Edit /etc/php5/fpm/php.ini

{% highlight ini %}
short_open_tag = Off
magic_quotes_gpc = Off
register_globals = Off
session.autostart = Off
date.timezone = Europe/Paris
{% endhighlight %}

### PHP OPCode cache

   * PHP = 5.5 : OPcache
  
#### PHP OPCode Settings

   * Work in progress

#### Notes

OPcache share his cache between all child process of a PHP master process. So to avoid cache collision we need a **master process per vhost**.

### Apache modules

   - Edit /etc/apache2/apache2.conf

   * mod_rewrite On
   * mod_headers On
   * mod_expires On
   * mod_deflate On

### Apache configuration

Options FollowSymLinks

### Mysql configuration

Default collation set to utf8\_unicode\_ci

## System requirements

 - SSH :
   * Allow key authentification
   * Allow agent forwarding
 - logrotate on shared/app/logs/prod.log
 - Apache DOCUMENT_ROOT on current/web/
 - crontab enabled and managable by the system user
 - access to Apache log
 - user shell set to /bin/bash
 - FTP account with specific credentials on shared/app/Resources/exchange

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
