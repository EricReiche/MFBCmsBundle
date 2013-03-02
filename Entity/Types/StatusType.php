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
 * Enum status type
 */
class StatusType extends AbstractType
{
    /**
     * @var string
     */
    protected $type = 'StatusType';

    const ENABLED  = 'Enabled';
    const DISABLED = 'Disabled';

    /**
     * @var array
     */
    public static $choices = array(
        self::ENABLED  => 'Enabled',
        self::DISABLED => 'Disabled',
    );
}
