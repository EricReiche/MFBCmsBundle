<?php

namespace MFB\CmsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

use MFB\CmsBundle\Service\CmsBlockService;

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
class CmsBlockExtension extends \Twig_Extension
{
    /**
     * @var CmsBlockService
     */
    protected $blockService;

    /**
     * Constructor
     *
     * @param CmsBlockService $blockService
     *
     * @return CmsBlockExtension
     */
    public function __construct(CmsBlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    /**
     * Returns a list of functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'cmsblock' => new \Twig_Function_Method($this, 'getCmsBlock', array(
                'is_safe' => array('html')
            ))
        );
    }

    /**
     * Returns block content.
     *
     * @param string $name
     *
     * @return string
     */
    public function getCmsBlock($name)
    {
        return $this->blockService->getContent($name);
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'CmsBlock';
    }

}

