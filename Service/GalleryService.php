<?php

namespace MFB\CmsBundle\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

use Doctrine\ORM\EntityManager;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use MFB\CmsBundle\Entity\Gallery;
use MFB\CmsBundle\Entity\Media;

use MFB\CmsBundle\Entity\Types\GalleryTypeType,
    MFB\CmsBundle\Entity\Types\StatusType,
    MFB\CmsBundle\Entity\Types\MediaParentType,
    MFB\CmsBundle\Entity\Types\MediaTypeType;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Cms GalleryService
 */
class GalleryService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var
     */
    protected $translator;

    const UPLOAD_DIR = 'uploads';

    const WEB_DIR = '/../../../../../../web/';

    const ORIG_DIR = 'original/';

    /**
     * @param EntityManager $em         Entity manager
     * @param mixed         $translator Translator service
     *
     * @return GalleryService
     */
    public function __construct(EntityManager $em, $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * Get filesystem dir for uploads
     *
     * @return string
     */
    public static function getUploadPath()
    {
        $path = __DIR__ . static::WEB_DIR . static::getUploadUrl();

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /**
     * Get URL path for files
     *
     * @return string
     */
    public static function getUploadUrl()
    {
        return '/' . trim(static::UPLOAD_DIR, '/') . '/';
    }

    /**
     * Make sure the file doesn't exist yet (or rename it)
     *
     * @param string $fileName
     * @return string
     */
    public static function cleanFileName($fileName)
    {
        $extension = '.' . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $shortname = static::removeSpecialChars(pathinfo($fileName, PATHINFO_FILENAME));
        $fileName = $shortname . $extension;
        while (file_exists(static::getUploadPath() . static::ORIG_DIR . $fileName)) {
            $shortname = static::removeSpecialChars(pathinfo($fileName, PATHINFO_FILENAME));
            preg_match('!^(.+\_)(\d+)$!imsU', $shortname, $matches);
            if (isset($matches[2])) {
                $fileName = $matches[1] . ((int)$matches[2] + 1) . $extension;
            } else {
                $fileName = $shortname . '_2' . $extension;
            }
        }
        return $fileName;
    }

    /**
     * Remove any special characters
     *
     * @param string $fileName
     * @return string
     */
    public static function removeSpecialChars($fileName)
    {
        return preg_replace('!\W+!imsU', '_', $fileName);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string       $parentType
     * @param int          $parentId
     *
     * @return bool
     */
    public function handleUpload($uploadedFile, $parentType = null, $parentId = null)
    {
        try {
            $fileName = $this->cleanFileName($uploadedFile->getClientOriginalName());

            $uploadedFile->move($this->getUploadPath() . static::ORIG_DIR, $fileName);
            $shortname = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION));

            $media = new Media();
            $media->setSlug($fileName);
            $media->setTitle($shortname);
            $media->setActive(true);

            $media->setParentId($parentId);
            $media->setParentType($parentType);

            $media->setType(MediaTypeType::getTypeByExtension($extension));
            $this->em->persist($media);
            $this->em->flush();

            return array('file' => $uploadedFile);
        } catch (\Exception $e) {
            // @todo error handling
            return array('error' => $e->getMessage());
        }
    }

    /**
     * Load one Media object by ID
     *
     * @param int $id
     *
     * @return Media
     */
    public function loadImage($id)
    {
        $repo = $this->em->getRepository('MFBCmsBundle:Media');
        return $repo->find($id);
    }

    /**
     * Load one Media object by ID
     *
     * @param Media|int $id
     * @param int       $width
     * @param int       $height
     *
     * @return string
     */
    public function getMediaUrl($id, $width = null, $height = null)
    {
        if (!($id instanceof Media)) {
            $media = $this->loadImage($id);
        }
        $orignalUrl = static::getUploadUrl() . static::ORIG_DIR . $media->getSlug();
        $orignalPath = static::getUploadPath() . static::ORIG_DIR . $media->getSlug();

        if (!file_exists($orignalPath)) {
            return false;
        }

        if (is_null($width) && is_null($height)) {
            return $orignalUrl;
        }

        $thumbnailDir = static::getUploadPath() . $width . 'x' . $height . '/';
        $thumbnailUrlDir = static::getUploadUrl() . $width . 'x' . $height . '/';
        $thumbnailPath = $thumbnailDir . $media->getSlug();
        $thumbnailUrl = $thumbnailUrlDir . $media->getSlug();
        if (!file_exists($thumbnailPath)) {
            $imagine = new Imagine();
            $image = $imagine->open($orignalPath);
            $thumbnail = $image->thumbnail(new Box($width, $height));
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0777, true);
            }
            $thumbnail->save($thumbnailPath);
        }

        return $thumbnailUrl;
    }

    /**
     * Load one Media object by ID
     *
     * @param int $id
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function getMediaLink($id, $width, $height)
    {
        $media = $this->loadImage($id);
        $original = $this->getMediaUrl($media);
        $thumbNail = $this->getMediaUrl($media, $width, $height);
        return '<a href="' . $original . '><img src="' . $thumbNail . '" class="thumbnail"/></a>';
    }
}
