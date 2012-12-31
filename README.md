# MFB CMSBundle

This bundle offers some CMS functionality

 - Dynamic blocks: Include "templates" from DataBase anywhere on the page
 - Press releases: Kind of a "news" system for press releases. There is a "current" page which displays the newest release and an "archive" which contains a list of all past releases with the teaser content.
 - News: basic implementation of a blog/news system.
 - Pages: Static content pages
 - Menu: Navigation tree

# Dependencies

Depends on doctrine extensions (nested sets tree for menu), TwigStringBundle (blocks) & Presta Sitemap Bundle.
The menu frontend templates are designed to work with the Twitter Bootstrap.
Uses the silk icon set from http://www.famfamfam.com/lab/icons/silk/.
Uses the dynatree library from http://wwwendt.de/tech/dynatree/doc/dynatree-doc.html
Depends on twitter bootstrap JS, jQuery, jQuery UI, jQuery cookie & jQuery form loaded (put it in web/js/).

# Installation

Download the silk icon set from http://www.famfamfam.com/lab/icons/silk/ and put it to your webroot under /img/silk/

 Add the following to your config.yml

```yaml
lk_twigstring: ~

stof_doctrine_extensions:
    default_locale: de_DE

    # Only used if you activated the Uploadable extension
    uploadable:
        # Default file path: This is one of the three ways you can configure the path for the Uploadable extension
        default_file_path:       %kernel.root_dir%/../web/uploads

        # Mime type guesser class: Optional. By default, we provide an adapter for the one present in the HttpFoundation component of Symfony
        mime_type_guesser_class: Stof\DoctrineExtensionsBundle\Uploadable\MimeTypeGuesserAdapter

        # Default file info class implementing FileInfoInterface: Optional. By default we provide a class which is prepared to receive an UploadedFile instance.
        default_file_info_class: Stof\DoctrineExtensionsBundle\Uploadable\UploadedFileInfo
    orm:
        default:
            tree: true
            timestampable: true
            translatable: true
            sluggable: true
            loggable: true
```

run composer update

```sh
composer.phar update
```

 Add the following to the end of your routing.yml

```yaml
mfb_cms:
    resource: "@MFBCmsBundle/Controller/"
    type:     annotation
    prefix:   /

mfb_content_show:
    pattern:   /{slug}
    defaults:  { _controller: MFBCmsBundle:Page:show }
    requirements:
        slug:  .+
```

Create an app/Resources/views/layout_pages.html.twig which is extended by the templates.