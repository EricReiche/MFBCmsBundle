<?php

namespace MFB\CmsBundle\Twig\Extension;

use MFB\CmsBundle\Entity\Types\MediaParentType;
use \Sonata\FormatterBundle\Formatter\MarkdownFormatter;
use MFB\CmsBundle\Service\GalleryService;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Twig extension to include CMS blocks in templates
 */
class CmsHelperExtension extends \Twig_Extension
{
    /**
     * @var MarkdownFormatter
     */
    protected $markdown;

    /**
     * @var GalleryService
     */
    protected $galleryService;

    /**
     * @param MarkdownFormatter $markdown
     * @param GalleryService    $galleryService
     *
     * @return CmsHelperExtension
     */
    public function __construct(MarkdownFormatter $markdown, GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
        $this->markdown = $markdown;
    }

    /**
     * Returns a list of functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'classname' => new \Twig_Function_Method($this, 'getClassName'),
            'uploadEnabled' => new \Twig_Function_Method($this, 'isUploadEnabled')
        );
    }

    /**
     * Returns a list of functions.
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            'cmsrender' => new \Twig_Filter_Method($this, 'cmsRender', array('is_safe' => array('html')))
        );
    }

    /**
     * Returns classname
     *
     * @param object $object
     *
     * @return string
     */
    public function getClassName($object)
    {
        $className = get_class($object);

        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * Check if upload is enabled for this entity
     *
     * @param object $object
     *
     * @return string
     */
    public function isUploadEnabled($object)
    {
        $className = $this->getClassName($object);

        return in_array($className, MediaParentType::getValues());
    }

    /**
     * Apply multiple filters to CMS
     *
     * @param string $content
     *
     * @return string
     */
    public function cmsRender($content)
    {
        return $this->markdown->transform($this->galleryService->parseContent($content));
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'CmsHelper';
    }

}
