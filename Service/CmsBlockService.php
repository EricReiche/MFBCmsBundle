<?php

namespace MFB\CmsBundle\Service;

use MFB\CmsBundle\Entity\Block;

use Doctrine\ORM\EntityManager;

use Symfony\Bundle\TwigBundle\TwigEngine;

use MFB\CmsBundle\Entity\Types\StatusType;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Cms block service
 */
class CmsBlockService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TwigEngine
     */
    protected $twigstring;

    /**
     * @param EntityManager $em         Entity manager
     * @param TwigEngine    $twigstring Twig engine
     *
     * @return CmsBlockService
     */
    public function __construct(EntityManager $em, TwigEngine $twigstring)
    {
        $this->em          = $em;
        $this->twigstring  = $twigstring;
    }

    /**
     * Get block content
     *
     * @param string $name
     *
     * @return string
     */
    public function getContent($name)
    {
        $content = '';
        /** @var $blockRepository \MFB\CmsBundle\Entity\Repository\BlockRepository */
        $blockRepository = $this->em->getRepository('MFBCmsBundle:Block');
        /** @var $block Block */
        $block = $blockRepository->findOneBy(array('slug' => $name, 'status' => StatusType::ENABLED));

        if ($block && ($block->getStatus() == StatusType::ENABLED)) {
            $content = $block->getContent();
        }

        return $this->twigstring->render($content);
    }
}
