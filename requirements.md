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

### SSH ~/.ssh/authorized_key

    ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCnMrC6imYGpQPHYkoR065HhmRqncjUKptp94v/rIANgMVaZdxdeI5Lf76qDVS2nDL+59d6WVW1IDb8Yh1WH6GZ3H9c6wGu17ylMBGJ2GgDS0/aG6Fe3in9jn0cmc0ik1Rmyt/sleyBx+X1lia2IE+4cqSJhe/l+EV+s5fmhM6DlFl46vVvhByDRUUfcZlUEwQVd4LxYrs+Bsgz3Kj/B3sOMwm004OpYxbcnQoOmddDjQYKKWo1VCn2vUud+v/iwL7z7xO+IENfRX08nSe+2qzhFUdFdj6h/ImBUctDFNM8rw1vLf6OBBduo5hOZqOVA2rivAmOhfdlKol7xHoC+Knv crespeaun@localhost.localdomain
    ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEApgU4AVX7w0DphqWhOS2/NZtDlfgjvfwdHH0K+Rr2MjSVLFrTot6xn7ww5Q4AmXGp5Q78ddirPxM1MQK8Uyd6REAawLEKLu1g4ItRo4rEer2lj5eo+UTc8IaYGiYvON/vrB1tV/gBv5zCwrQmDpEZ8aIDa7bh3d/tBlfe2MhoNomlcwrUBrnxRg6B46P8CsNTOWI0gXAmcdTeuRVV0wjxCgotV5dCIJfIa00bHVzCm0nzdJIZijdezdfMB/cLSExoIn0lxJL4014EciadsGYbksENwdvL5u4rC0jXrM9rZri97fYofX4ZiaSndPUjvqhQdVjFKGaDzjx7k03H/dNuqw== laurent@nl-box
    ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDGX9dRgNvKM0ofrbSDXRiJz3m0E+GCDZKpXylBlvaUN+57kijraGiRW+Mmc5zm21aXQbSoM+05igBUHkBO0pF6jzHCDrSSj6xIrhdgVIzDuckOXEwwHx/5C/+85ooPRNMI+8b6uos7tESsOg+yFJWreGYdiXbFVLiSNnQXVJTdurJVQg32NBtaXej/wPx09Pq373dNtOIZagAPfSaaulmI/uSrl51Jj3L89EYzwRP8va/2IRMhloaPwTW0XFJ5D8hReX+Cm9QPhViLnucGazwznfOXBoz4OXjW2pI7aQItlmFd0Dl+tqt40KE4I5aNdstKAzAs7mzJTVujmFY3kG0F philippe@philippe-ESPRIMO-P5731
    ssh-dss AAAAB3NzaC1kc3MAAACBALu6QUPkMa0jYayejRpf/DuHIL9ds4vaU5WvrV8clKmDDaZ7k0kUe2oXGggX5R1Rj63/JGuc1cp8kmB2pIVAt3eFo+4sOnsnw9JTxaFDpcnAm5g92K5Vb3ytN/pMSg+qhlmvpvVcNhLyGJjuUWd4LuYHocoZTSctS9IvraVpnMNrAAAAFQDKtk8HIdxoAZxEOwOT/zvqlvveIwAAAIBT6X3TaiUqFnV24w9qb5bSLRFqbNtzgNqx7dlTcwrpDwTHp9O7QJ8wxILxavmFrQ2zyyjaxlminexwcoNsm/k0g2dXbV5fT7LIROar2aqjwshWi95KZ0wM6OPH4BM9rwnB4hsop17dj+Uhb683YhVi79oL5FWzo0ILlUi9z0JdCgAAAIAf7LVJlceP0IrCSpr1kS8tvavWBPqcrFsTRcX+A9LggXV4GFF/EP/dndax541QiSUkmBYzLJ7lWQC36bWFIuFvTVoFXds72VrrWONlYYA9tyZ2TfkLmVUe1pKzusZV83+WxOpHvBaEFMJWEuQMFjUr0wjoKOvakWivFOWDyuSTCg== erwan_new@er-box.phare
    ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCjb2D5AU7IFp9EPi92JuLnfDERIeyXgu93Skh64WuELSVYNGPZ4+JrQPBcsEAJtbjCEBp+4n6eSoZBVtJGjh+E4PhSLzpyx79Opndlph7hLFPyr+cNdZnL5C3OJvI506zQ2O8WJH71vFvBdftH9jmz4e3W0unuJi8ODxCtDz+/gAliQQ3tmRmV3jdtKJtWpnOOT5nfj9tbuy4i0Q66rvXEQVc4xDACyqBgd/oQ8cohixLYHs1NyzXcJ10kwnusaDQ1TQix0fBNdrfmURTacuB+2H48JCSAyL3fY1/webd00LD1AMQXLocrJAai3fsb1g2XiA3ZEGD+4+d/jv2GBhqd charlie@cb-box.local.phare
    ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAt3FOVzi5lIoFp7m8Ab3HK5uhotiyN/gGun83Q9RzqoVV7mg2tNOdt/qQcYS5dWPqpEe0nV2DbB98z0aQrsRmM03bif2uFQqsTPMQAIzVDE0uPV4V4nicRDtw0wAFmgG1hRLErxtKoN6v1KTqKdPrNHfgfMJzrDoJKEfcWuxFn/CR+8BzDFsl9ovoa8K/aFcRtW0kus93R21TlNEc+2iFL5trxaMkYjH30How3zxw3EmrcEySyr3taRkj3qXuIsgRskLSAgDUIK8tfCCUty9lJoJ6gS6bRnFrt6N2aL7+bQxXHTVKNVtTi10TlTgCdtYhtqhus0TzHP6pNsriFSqtAQ== Hervé@HERVÉ-PC
    ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDJqvPQHozV/cvVnKEpcPJ07MyoyKKQvxtDVcRQEifknNMWxtNEyXV1AlPaaJ2naDijn6dniavcJLY3C41rAfU46anqVTK9OUklj5viIl0MuDPxSEBkmh2QTuuJS0XgFJ7tICeiq/kKmcxaLYuxxqQ0SW4Bbilz7H+zQ8G8jsrE87B+fXOs63gCImIHl3R0cJAoA7pmxVqifoiJOlscvuuPC4tZDydf+O7P1KzmlPzi3GmGaN9INwJ5MV3ClYZE6o23xh/YH+EIIcNzphFhc3zBg90RVkm4obXLyYm00FYvjWheHwscR1VCDbbh2jS7QiiWJHPxlJ8KAsyX1teVHSYr blake@localhost.localdomain
