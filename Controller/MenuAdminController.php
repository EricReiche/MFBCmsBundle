<?php

namespace MFB\CmsBundle\Controller;

use MFB\CmsBundle\Entity\Types\MenuNodeLinkTypeType;
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

        return new Response($this->get('mfb_cms.service.cms_menu')->loadJsonTree());
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
        $root = $request->get('root');
        $prevId = $request->get('prev');
        $parentId = $request->get('parent');

        $newNode = new MenuNode();
        $newNode->setLinkPlain('/');
        $newNode->setTitle('NewNode');
        $newNode->setActive(false);

        if ($root == 1) {
            $em->persist($newNode);
        } elseif (is_numeric($prevId)) {
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
        $targetId = $request->get('target');
        $mode = $request->get('mode');

        if (!is_null($active)) {
            $node->setActive((bool)$active);
            $em->persist($node);
        }
        if (!is_null($targetId) && !is_null($mode)) {
            $target = $repo->find($targetId);
            switch ($mode) {
                case 'over':
                    $repo->persistAsFirstChildOf($node, $target);
                    break;
                case 'before':
                    $repo->persistAsPrevSiblingOf($node, $target);
                    break;
                case 'after':
                    $repo->persistAsNextSiblingOf($node, $target);
                    break;
                default:
                    return false;
            }
        }

        $em->flush();

        return new Response(json_encode(true));
    }

    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function ajaxFormAction()
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
            return new Response('');
        }
        $node = $repo->find($id);

        $form = $this->createFormBuilder($node)
            ->add('title', 'text')
            ->add('linkPlain', 'text')
            ->add('linkType', 'choice', array('choices' => MenuNodeLinkTypeType::getChoices()))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($node);
                $em->flush();
            }
        }

        return $this->render(
            'MFBCmsBundle:MenuAdmin:form.html.twig', array(
            'action' => 'form',
            'form' => $form->createView(),
            'object' => $node
        ));
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
         */
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($this->admin->getClass());
        $node = $repo->find($id);


        foreach ($this->get('mfb_cms.service.cms_menu')->loadAllChildren($node) as $child) {
            $repo->removeFromTree($child);
        }
        $repo->removeFromTree($node);

        $repo->verify();
        $repo->recover();
        $em->flush();

        return new Response(json_encode(true));
    }
}