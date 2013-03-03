<?php

namespace MFB\CmsBundle\Service;

use Doctrine\ORM\EntityManager;

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

        return array(
            'query' => $query,
            'suggestions' => array(
                array('value' => $type . '111', 'data' => '1'),
                array('value' => $type . '222', 'data' => '2'),
                array('value' => $type . '333', 'data' => '3'),
            )
        );
    }


}
