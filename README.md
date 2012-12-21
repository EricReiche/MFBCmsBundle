# MFB CMSBundle

This bundle offers some CMS functionality

 - Dynamic blocks: Include "templates" from DataBase anywhere on the page
 - Press releases: Kind of a "news" system for press releases. There is a "current" page which displays the newest release and an "archive" which contains a list of all past releases with the teaser content.

# Dependencies

 Depends on memcached, TwigStringBundle, Doctrine Cache Bundle & Presta Sitemap Bundle.
 The cms blocks are put in memcache. This is an interim solution and should be replaced by ESI.

# Installation

 Add the following to your config.yml

```yaml
lk_twigstring: ~

liip_doctrine_cache:
    namespaces:
        # name of the service (aka liip_doctrine_cache.ns.mc)
        mc:
            namespace: mfb
            type: memcache
            # name of a service of class Memcached that is fully configured (optional)
            # id: my_memcached_service
            port: 11211
            host: localhost
```

run composer update

```
composer.phar update
```