# MFB CMSBundle

This bundle offers some CMS functionality

 - Dynamic blocks: Include "templates" from DataBase anywhere on the page
 - Press releases: Kind of a "news" system for press releases. There is a "current" page which displays the newest release and an "archive" which contains a list of all past releases with the teaser content.

# Dependencies

 Depends on TwigStringBundle & Presta Sitemap Bundle.
 The cms blocks are put in memcache. This is an interim solution and should be replaced by ESI.

# Installation

 Add the following to your config.yml

```yaml
lk_twigstring: ~
```

run composer update

```
composer.phar update
```