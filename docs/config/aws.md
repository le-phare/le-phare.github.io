---
layout: default
title: AWS
parent: Configuration
nav_order: 2
---

# AWS 

Configurations spécifique en cas d'installatio sur la plateforme Amazon Web Service (AWS).

## Cloudfront

Les entêtes HTTP suivants doivent être transmis au serveur applicatif EC2 :

 * Authorization
 * CloudFront-Forwarded-Proto
 * Host
 * Accept
 * Referer