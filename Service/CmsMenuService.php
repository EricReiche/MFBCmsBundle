<?php

namespace MFB\CmsBundle\Service;

use MFB\CmsBundle\Entity\Block;
use MFB\CmsBundle\Entity\MenuNode;

use Doctrine\ORM\EntityManager;

use MFB\CmsBundle\Entity\Types\MenuNodeLinkTypeType;
use Symfony\Bundle\TwigBundle\TwigEngine;

use MFB\CmsBundle\Entity\Types\BlockStatusType;

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
class CmsMenuService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var mixed
     */
    protected $container;

    /**
     * @var mixed
     */
    protected $serializer;

    const ENTITY = 'MFBCmsBundle:MenuNode';

    /**
     * @param EntityManager $em         Entity manager
     * @param mixed         $container  Service Container
     * @param mixed         $serializer Serializer
     *
     * @return CmsMenuService
     */
    public function __construct(EntityManager $em, $container, $serializer)
    {
        $this->em         = $em;
        $this->container  = $container;
        $this->serializer = $serializer;
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
        /** @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $repo */
        $repo = $this->em->getRepository(self::ENTITY);
        $node = $repo->findOneBy(array('linkPlain' => $name, 'lvl' => 0));
        if (!($node instanceof MenuNode)) {
            return '<!-- Root node with id "' . $name . '" not found -->';
        }
        $menu = $this->loadTree($node, true);
        $menu = array_shift($menu);
        $data = array('menu' => $menu);

        $rendered = $this->container->get('templating')->render('MFBCmsBundle:Menu:menu.html.twig', $data);

        return $rendered;
    }

    /**
     * @param MenuNode $node
     *
     * @return array
     */
    public function loadAllChildren($node)
    {
        $query = $this->em
            ->createQueryBuilder()
            ->select('node')
            ->from(self::ENTITY, 'node')
            ->orderBy('node.root, node.lft', 'ASC')
            ->andWhere('node.root = :root')
            ->andWhere('node.lft > :left')
            ->andWhere('node.rgt < :right')
            ->setParameter('root', $node->getRoot())
            ->setParameter('left', $node->getLft())
            ->setParameter('right', $node->getRgt())
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param MenuNode $node
     * @param bool     $activeOnly
     *
     * @return array|string
     */
    public function loadTree($node = null, $activeOnly = false)
    {
        /** @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $repo */
        $repo = $this->em->getRepository(self::ENTITY);

        $qb = $this->em
            ->createQueryBuilder()
            ->select('node.title, node.id, node.active, node.lvl, node.lft, node.rgt, node.root, node.linkPlain, node.linkArguments, node.linkType')
            ->from(self::ENTITY, 'node')
            ->orderBy('node.root, node.lft', 'ASC');

        if ($node instanceof MenuNode) {
            $qb->andWhere('node.root = :root')
                ->setParameter('root', $node->getRoot());
        }
        if ($activeOnly) {
            $qb->andWhere('node.active = true');
        }
        $query = $qb->getQuery();
        $repo->setChildrenIndex('children');
        $result = $query->getArrayResult();

        foreach ($result as $key => $node) {
            $result[$key]['select'] = $node['active'];
            $result[$key]['key'] = $node['id'];
            unset($result[$key]['active']);

            $result[$key]['isFolder'] = ($node['rgt'] - $node['lft'] > 1);

            if ($node['linkType'] == MenuNodeLinkTypeType::TEXT) {
                $result[$key]['link'] = $node['linkPlain'];
            } elseif ($node['linkType'] == MenuNodeLinkTypeType::PATH) {
                $result[$key]['link'] = $node['linkPlain'];
            } elseif ($node['linkType'] == MenuNodeLinkTypeType::SEPARATOR) {
                $result[$key]['link'] = '';
            } elseif ($node['linkType'] == MenuNodeLinkTypeType::NOLINK) {
                $result[$key]['link'] = $node['linkArguments'];
            }
        }

        return $repo->buildTree($result, array('decorate' => false));
    }

    /**
     * @return string (json)
     */
    public function loadJsonTree()
    {
        return $this->serializer->serialize($this->loadTree(), 'json');
    }
}
