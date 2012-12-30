<?php

namespace MFB\CmsBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

use MFB\CmsBundle\Service\CmsMenuService;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Twig extension to include CMS menu in templates
 */
class CmsMenuExtension extends \Twig_Extension
{
    /**
     * @var CmsMenuService
     */
    protected $menuService;

    /**
     * Constructor
     *
     * @param CmsMenuService $menuService
     *
     * @return CmsMenuExtension
     */
    public function __construct(CmsMenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Returns a list of functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'cmsmenu' => new \Twig_Function_Method($this, 'getCmsMenu', array(
                'is_safe' => array('html')
            ))
        );
    }

    /**
     * Returns menu content.
     *
     * @param string $name
     *
     * @return string
     */
    public function getCmsMenu($name)
    {
        return $this->menuService->getContent($name);
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'CmsMenu';
    }

}

