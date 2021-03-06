<?php

namespace MFB\CmsBundle\Entity\Types;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Abstract Enum methods
 */
abstract class AbstractType
{
    /**
     * @var array
     */
    public static $choices = array(
    );

    /**
     * Get values for the Enum field
     *
     * @return array
     */
    public static function getChoices()
    {
        return static::$choices;
    }

    /**
     * Get values
     *
     * @static
     * @return array
     */
    public static function getValues()
    {
        return array_keys(static::$choices);
    }

    /**
     * Get readable block type
     *
     * @param string $key Key of array
     *
     * @static
     * @return mixed
     */
    public static function getReadableValue($key)
    {
        return isset(static::$choices[$key])
            ? static::$choices[$key]
            : false;
    }
}
