<?php
namespace MFB\CmsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Form\FormMapper,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Route\RouteCollection;

use MFB\CmsBundle\Entity\Types\GalleryTypeType,
    MFB\CmsBundle\Entity\Types\MediaParentType,
    MFB\CmsBundle\Entity\Types\MediaTypeType;

use MFB\CmsBundle\Service\GalleryService;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 */
class MediaAdmin extends Admin
{
    /**
     * The label class name  (used in the title/breadcrumb ...)
     *
     * @var string
     */
    protected $classnameLabel = 'media';

    /**
     * The base route pattern used to generate the routing information
     *
     * @var string
     */
    protected $baseRoutePattern = '/media';

    /**
     * @return GalleryService
     */
    protected function getGalleryService()
    {
        return $this->get('mfb_cms.service.gallery');
    }

    /**
     * Gets a service.
     *
     * @param string $id The service identifier
     *
     * @return object The associated service
     */
    protected function get($id)
    {
        return $this->configurationPool->getContainer()->get($id);
    }
    /**
     * Configure the Admin routes
     *
     * @param \Sonata\AdminBundle\Route\RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('ajax_upload');
        $collection->add('ajax_search');
        $collection->add('embed');
        $collection->remove('edit');
    }
}