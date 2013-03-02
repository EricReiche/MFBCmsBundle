<?php

namespace MFB\CmsBundle\Service;

use MFB\CmsBundle\Entity\Block;

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

    public static $imageTypes = array('jpg', 'jpeg', 'png', 'gif');

    public static $videoTypes = array('mkv', 'avi', 'mp4', 'flv', 'mov');

    const UPLOAD_DIR = 'uploads';

    const WEB_DIR = '/../../../../../../web/';

    /**
     * @param EntityManager $em Entity manager
     *
     * @return GalleryService
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
     * @param UploadedFile $uploadedFile
     *
     * @return bool
     */
    public function handleUpload($uploadedFile)
    {
        try {
            $fileName = $this->cleanFileName($uploadedFile->getClientOriginalName());

            $result = $uploadedFile->move($this->getUploadPath(), $fileName);
            $shortname = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);

            $media = new Media();
            $media->setSlug($fileName);
            $media->setTitle($shortname);
            $media->setStatus(StatusType::ENABLED);

            //@todo
//            $media->setParentId();
//            $media->setParentType();

            if (in_array($extension, static::$imageTypes)) {
                $media->setType(MediaTypeType::PICTURE);
            } elseif (in_array($extension, static::$videoTypes)) {
                $media->setType(MediaTypeType::VIDEO);
            } else {
                // @todo translate
                return array('error' => 'Invalid file type.');
            }
            $this->em->persist($media);
            $this->em->flush();

            return array('file' => $uploadedFile);
        } catch (\Exception $e) {
            // @todo error handling
            return array('error' => $e->getMessage());
        }
    }

    /**
     * Remove any special characters and make sure the file doesn't exist yet (or rename it)
     *
     * @param string $fileName
     * @return string
     */
    protected function cleanFileName($fileName)
    {
        $shortname = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $shortname = preg_replace('!\W+!imsU', '_', $shortname);
        $fileName = $shortname . $extension;
        while (file_exists($this->getUploadPath() . $fileName)) {
            preg_match('!^(.+\_)(\d+)$!imsU', $shortname, $matches);
            if (isset($matches[2])) {
                $fileName = $matches[1] . ((int)$matches[2] + 1) . $extension;
            } else {
                $fileName = $shortname . '_2' . $extension;
            }
        }
        return $fileName;
    }
}
