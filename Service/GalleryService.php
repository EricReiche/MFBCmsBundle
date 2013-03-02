<?php

namespace MFB\CmsBundle\Service;

use MFB\CmsBundle\Entity\Block;

use Doctrine\ORM\EntityManager;

use Symfony\Bundle\TwigBundle\TwigEngine;

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
     * @param EntityManager $em Entity manager
     *
     * @return GalleryService
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
