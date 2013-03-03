<?php

namespace MFB\CmsBundle\Twig\Extension;

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
 * Twig extension to include CMS blocks in templates
 */
class CmsHelperExtension extends \Twig_Extension
{
    /**
     * Returns a list of functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'classname' => new \Twig_Function_Method($this, 'getClassName')
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
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'CmsHelper';
    }

}

