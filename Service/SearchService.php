<?php

namespace MFB\CmsBundle\Service;

use Doctrine\ORM\EntityManager;
use MFB\CmsBundle\Entity\Types\MediaParentType;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * Cms SearchService
 */
class SearchService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em Entity manager
     *
     * @return SearchService
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function contentSuggest($type, $query)
    {
        $entity = 'MFBCmsBundle:' . $type;
        $repository = $this->em->getRepository($entity);

        $qb = $repository->createQueryBuilder('c')
            ->select('c')
            ->where('c.' . MediaParentType::getSearchField() . ' LIKE :search')
            ->setParameter('search', '%' . $query . '%');

        $searchResult = $qb->getQuery()->getResult();
        $result =
            array(
                'query' => $query,
                'suggestions' => array()
            );
        /** @var News|Page|Block|Gallery|PressRelease $hit */
        foreach ($searchResult as $hit) {
            $result['suggestions'][] = array('value' => (string)$hit, 'data' => $hit->getId());
        }
        return $result;
    }


}
