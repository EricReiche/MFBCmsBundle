<?php

namespace MFB\CmsBundle\Entity\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Enum block type
 */
class BlockTypeType
{
    /**
     * @var string
     */
    protected $type = 'BlockTypeType';

    const TEXT = 'text';

    /**
     * @var array
     */
    public static $choices = array(
        self::TEXT => 'Text',
    );

    /**
     * Get values for the Enum field
     *
     * @return array
     */
    public static function getChoices()
    {
        return self::$choices;
    }

    /**
     * Get values
     *
     * @static
     * @return array
     */
    public static function getValues()
    {
        return array_keys(self::$choices);
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
        return isset(self::$choices[$key])
            ? self::$choices[$key]
            : false;
    }
}
