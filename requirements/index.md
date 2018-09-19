---
layout: page
title: Hosting requirements
---

## Hardware requirements

 * CPU >= 2 core
 * RAM >= 2GB
 * Project Storage >=20GB

## Recommanded Operating System

 * Last stable [Debian](https://www.debian.org) (currently Debian Stretch)

## Software requirements

 - PHP >= 7.2
 - Apache = 2.4
 - PostgreSQL >= 9.6
 - Memcached
 - git
 - curl

### PHP extensions

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
   * ssh2
   * apcu
   * apcu-bc
   * exif

### PHP settings

{% highlight ini %}
short_open_tag = Off
magic_quotes_gpc = Off
register_globals = Off
session.autostart = Off
date.timezone = Europe/Paris
upload_max_filesize = 32M
post_max_size = 33M
sys_temp_dir = /var/tmp
upload_dir = /var/tmp
{% endhighlight %}

#### Memcached Settings

PHP sessions stored in **memcached**.

{% highlight ini %}
session.save_handler = memcached
session.save_path = localhost:11211
memcached.sess_lock_wait_min = 150
memcached.sess_lock_wait_max = 150
memcached.sess_lock_retries = 800
{% endhighlight %}

#### OPcache Settings

{% highlight ini %}
opcache.revalidate_freq=0
opcache.validate_timestamps=0
opcache.max_accelerated_files=7963
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.fast_shutdown=1
{% endhighlight %}

#### Notes

### Apache modules

   * mod_rewrite On
   * mod_headers On
   * mod_expires On
   * mod_deflate On

### Apache configuration

{% highlight shell %}
Options FollowSymLinks
AllowOverride AuthConfig Limit FileInfo Indexes Options=Indexes,FollowSymLinks
{% endhighlight %}

#### Recommended configuration

{% highlight shell %}
ServerSignature Off
ServerTokens Prod
{% endhighlight %}

## System requirements

 - SSH :
   * Allow key authentification
   * Allow agent forwarding
 - logrotate on shared/app/logs/*.log
 - Apache DOCUMENT_ROOT on current/web/
 - crontab enabled and managable by the system user
 - access to Apache logs
 - user shell set to /bin/bash
 - FTP account with specific credentials on shared/app/Resources/exchange

## Network requirements

 * Allow smtp output
 * website SHOULD be accessible with two domains (www.site.com and static.site.com)
 * all domains MUST be accessible through HTTPS
 
### SSH inputs

 * 212.198.41.172
 * 109.190.225.66
 * 37.59.114.65

### SSH outputs

 * github.com (beware of their [ip range](https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist))
 * bitbucket.org
 * gitlab.com

### HTTP/HTTPS output

 * github.com ([IP range](https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist))
 * bitbucket.org ([IP list](https://confluence.atlassian.com/bitbucket/what-are-the-bitbucket-cloud-ip-addresses-i-should-use-to-configure-my-corporate-firewall-343343385.html))
 * gitlab.com
 * packagist.org
 * packagist.com
 * repo.packagist.com
 * getcomposer.org
 * api.rollbar.com
 * sentry.io
 * faros.lephare.com

### SSH Keys

```shell
curl -sL https://faros.lephare.com/lephare.keys >> ~/.ssh/authorized_keys
chmod 0600 ~/.ssh/authorized_keys
```
### AWS Cloudfront (if applicable)

The following headers must be forwarded to the web server : 

 * Authorization
 * CloudFront-Forwarded-Proto
 * Host
 * Accept
 * Referer

