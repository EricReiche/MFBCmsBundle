<?php

namespace MFB\CmsBundle\Twig\Extension;

use MFB\CmsBundle\Entity\Types\MediaParentType;
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
            'img' => new \Twig_Function_Method($this, 'getImage'),
            'imgLink' => new \Twig_Function_Method($this, 'getImageLink'),
            'imgGallery' => new \Twig_Function_Method($this, 'getImageGallery'),
        );
    }

    /**
     * Returns image URL
     *
     * @param int $id
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function getImage($id, $width = null, $height = null)
    {
        return $this->galleryService->getMediaUrl($id, $width, $height);
    }

    /**
     * Returns image URL
     *
     * @param int $id
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function getImageLink($id, $width = null, $height = null)
    {
        return $this->galleryService->getMediaLink($id, $width, $height);
    }

    /**
     * Returns gallery code
     *
     * @param string $type
     * @param int    $id
     * @param int    $width
     * @param int    $height
     *
     * @return string
     */
    public function getImageGallery($type, $id, $width = null, $height = null)
    {
        if (!in_array($type, MediaParentType::getValues()) || (int)$id < 1) {
            return '<!-- error including gallery -->';
        }
        return $this->galleryService->getGallery($type, (int)$id, $width, $height);
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

