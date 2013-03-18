<?php

namespace MFB\CmsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 */
class MFBCmsBundle extends Bundle
{
    /**
     * Presta sitemap bundle integration
     */
    public function boot()
    {
        /**
         * @var mixed $router
         * @var mixed $event
         */
        $router = $this->container->get('router');
        $event  = $this->container->get('event_dispatcher');

        if (class_exists('\Presta\SitemapBundle\PrestaSitemapBundle')) {
            //listen presta_sitemap.populate event
            $event->addListener(
                \Presta\SitemapBundle\Event\SitemapPopulateEvent::onSitemapPopulate,
                function (\Presta\SitemapBundle\Event\SitemapPopulateEvent $event) use ($router) {
                    // get absolute url
                    $url = $router->generate('pressrelease_list', array(), true);
                    // add url to the url-set
                    $event->getGenerator()->addUrl(
                        new \Presta\SitemapBundle\Sitemap\Url\UrlConcrete (
                            $url,
                            null,
                            \Presta\SitemapBundle\Sitemap\Url\UrlConcrete::CHANGEFREQ_WEEKLY,
                            1
                        ),
                        'content'
                    );

                }
            );
            //listen presta_sitemap.populate event
            $event->addListener(
                \Presta\SitemapBundle\Event\SitemapPopulateEvent::onSitemapPopulate,
                function (\Presta\SitemapBundle\Event\SitemapPopulateEvent $event) use ($router) {
                    // get absolute url
                    $url = $router->generate('pressrelease_current', array(), true);
                    // add url to the url-set
                    $event->getGenerator()->addUrl(
                        new \Presta\SitemapBundle\Sitemap\Url\UrlConcrete (
                            $url,
                            null,
                            \Presta\SitemapBundle\Sitemap\Url\UrlConcrete::CHANGEFREQ_WEEKLY,
                            1
                        ),
                        'content'
                    );

                }
            );
        }
    }
}
