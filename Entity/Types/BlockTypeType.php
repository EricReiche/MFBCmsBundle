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
 * Enum block type
 */
class BlockTypeType extends AbstractType
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
}
