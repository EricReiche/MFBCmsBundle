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
class MediaTypeType extends AbstractType
{
    /**
     * @var string
     */
    protected $type = 'MediaTypeType';

    const PICTURE  = 'picture';
    const VIDEO = 'video';
    const PDF = 'pdf';
    const FILE = 'file';

    public static $pictureTypes = array('jpg', 'jpeg', 'png', 'gif');
    public static $videoTypes = array('mkv', 'avi', 'mp4', 'flv', 'mov');
    public static $pdfTypes = array('pdf');

    /**
     * @var array
     */
    public static $choices = array(
        self::PICTURE  => 'Picture',
        self::VIDEO => 'Video',
        self::PDF => 'PDF',
        self::FILE => 'File',
    );

    /**
     * Get file extensions by Type.
     *
     * @param $type
     * @return array
     */
    public static function getExtensionsByType($type)
    {
        switch ($type) {
            case static::PICTURE:
                return static::$pictureTypes;
            case static::VIDEO:
                return static::$videoTypes;
            case static::PDF:
                return static::$pdfTypes;
        }

        return array();
    }

    /**
     * Return enum type by file extension
     *
     * @param $extension
     * @return string
     */
    public static function getTypeByExtension($extension)
    {
        foreach (static::getValues() as $type) {
            if (in_array($extension, static::getExtensionsByType($type))) {
                return $type;
            }
        }

        return static::FILE;
    }
}
