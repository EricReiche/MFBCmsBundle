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
 * Enum gallery type
 */
class GalleryTypeType extends AbstractType
{
    /**
     * @var string
     */
    protected $type = 'GalleryTypeType';

    const DETAIL  = 'detail';
    const GRID = 'grid';

    /**
     * @var array
     */
    public static $choices = array(
        self::DETAIL  => 'Detail',
        self::GRID => 'Grid',
    );
}
