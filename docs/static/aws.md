---
layout: default
title: AWS
parent: Configuration
nav_order: 2
---

# AWS 

Configuration spécifique en cas d'installation sur la plateforme Amazon Web Service (AWS).

## Cloudfront

Les entêtes HTTP suivants doivent être transmis au serveur applicatif EC2 :

 * Authorization
 * CloudFront-Forwarded-Proto
 * Host
 * Accept
 * Referer
