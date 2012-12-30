<?php

namespace MFB\CmsBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use MFB\CmsBundle\Entity\MenuNode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * News frontend controller
 */
class MenuAdminController extends Controller
{

    /**
     * return the Response object associated to the list action
     *
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function listAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        return $this->render(
            'MFBCmsBundle:MenuAdmin:list.html.twig', array(
            'action' => 'list'
        ));
    }

    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function ajaxTreeAction()
    {
        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        return new Response($this->loadJsonTree());
    }

    /**
     * @return string (json)
     */
    protected function loadJsonTree()
    {
        /**
         * @var \Doctrine\ORM\EntityManager                        $em
         * @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $repo
         */
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($this->admin->getClass());

        $query = $em
            ->createQueryBuilder()
            ->select('node.title, node.id, node.active, node.lvl, node.lft, node.rgt, node.root')
            ->from($this->admin->getClass(), 'node')
            ->orderBy('node.root, node.lft', 'ASC')
            ->getQuery();
        $repo->setChildrenIndex('children');
        $result = $query->getArrayResult();

        foreach ($result as $key => $node) {
            $result[$key]['select'] = $node['active'];
            $result[$key]['key'] = $node['id'];
            unset($result[$key]['active']);
        }

        $tree = $repo->buildTree($result, array('decorate' => false));

        return $this->get('serializer')->serialize($tree, 'json');
    }

    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function ajaxAddAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        /**
         * @var \Doctrine\ORM\EntityManager                        $em
         * @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $repo
         */
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($this->admin->getClass());

        $request = $this->getRequest();
        $prevId = $request->get('prev');
        $parentId = $request->get('parent');

        $newNode = new MenuNode();
        $newNode->setLinkPlain('/');
        $newNode->setTitle('NewNode');
        $newNode->setActive(false);

        if (is_numeric($prevId)) {
            $prevNode = $repo->find($prevId);
            $repo->persistAsPrevSiblingOf($newNode, $prevNode);
        } elseif (is_numeric($parentId)) {
            $parentNode = $repo->find($parentId);
            $repo->persistAsFirstChildOf($newNode, $parentNode);
        } else {
            return new Response(json_encode(false));
        }
        $em->flush();
        return new Response(json_encode(array('key' => $newNode->getId())));
    }

    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function ajaxSaveAction()
    {
        if (false === $this->admin->isGranted('EDIT')) {
            throw new AccessDeniedException();
        }

        $request = $this->getRequest();
        /**
         * @var \Doctrine\ORM\EntityManager                        $em
         * @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $repo
         * @var int                                                $id
         * @var MenuNode                                           $node
         */
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($this->admin->getClass());
        $id = $request->get('id');
        if (!is_numeric($id)) {
            return new Response(json_encode(false));
        }
        $node = $repo->find($id);

        $active = $request->get('active');
        if (!is_null($active)) {
            $node->setActive((bool)$active);
        }

        $em->persist($node);
        $em->flush();

        return new Response(json_encode(true));
    }

    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function ajaxDeleteAction()
    {
        if (false === $this->admin->isGranted('DELETE')) {
            throw new AccessDeniedException();
        }

        $request = $this->getRequest();
        $id = $request->get('id');
        /**
         * @var \Doctrine\ORM\EntityManager                        $em
         * @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $repo
         * @var MenuNode                                           $node
         * @var MenuNode                                           $parentNode
         */
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($this->admin->getClass());
        $node = $repo->find($id);
        if ($node instanceof MenuNode) {
            $parentNode = $node->getParent();
            $repo->removeFromTree($node);
            $em->clear();

            return new Response(json_encode(array('key' => $parentNode->getId())));
        }

        return new Response(json_encode(false));
    }
}