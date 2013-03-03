<?php

namespace MFB\CmsBundle\Twig\Extension;

use MFB\CmsBundle\Service\GalleryService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Twig extension to include media elements
 */
class CmsMediaExtension extends \Twig_Extension
{
    /**
     * @var GalleryService
     */
    protected $galleryService;

    /**
     * Constructor
     *
     * @param GalleryService $galleryService
     *
     * @return CmsMediaExtension
     */
    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    /**
     * Returns a list of functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'img' => new \Twig_Function_Method($this, 'getImage')
        );
    }

    /**
     * Returns image URL
     *
     * @param int $id
     *
     * @return string
     */
    public function getImage($id, $width = null, $height = null)
    {
        return $this->galleryService->getMediaUrl($id, $width, $height);
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'CmsMedia';
    }

}

