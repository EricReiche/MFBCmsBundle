<?php

namespace MFB\CmsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * MediaRepository
 */
class MediaRepository extends EntityRepository
{
    /**
     * @param string $parentType
     * @param int    $id
     * @param string $mediaType
     *
     * @return array
     */
    public function findByType($parentType, $id, $mediaType = null)
    {
        $filter = array('parentType' => $parentType, 'parentId' => $id);
        if (!is_null($mediaType)) {
            $filter['type'] = $mediaType;
        }

        return $this->findBy($filter);
    }
}
