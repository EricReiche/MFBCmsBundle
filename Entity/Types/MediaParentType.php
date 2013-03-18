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
 * Enum media type
 */
class MediaParentType extends AbstractType
{
    /**
     * @var string
     */
    protected $type = 'MediaParentType';

    /**
     * Make sure they are named after the entities they represent!!!
     * @see \MFB\CmsBundle\Service\SearchService::contentSuggest()
     */
    const BLOCK = 'Block';
    const GALLERY  = 'Gallery';
    const NEWS = 'News';
    const PAGE = 'Page';
    const PRESS = 'PressRelease';

    /**
     * @var array
     */
    public static $choices = array(
        self::BLOCK  => 'Block',
        self::GALLERY => 'Gallery',
        self::NEWS => 'News',
        self::PAGE => 'Page',
        self::PRESS => 'Pressrelease',
    );

    /**
     * Used for searching through entities
     *
     * @see \MFB\CmsBundle\Service\SearchService::contentSuggest()
     *
     * @return string
     */
    public static function getSearchField()
    {
        return 'title';
    }
}
