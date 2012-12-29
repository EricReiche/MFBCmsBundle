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
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
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
     * @return mixed
     */
    public function ajaxTreeAction()
    {
        /**
         * @var $em   \Doctrine\ORM\EntityManager
         * @var $repo \Gedmo\Tree\Entity\Repository\NestedTreeRepository
         */
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($this->admin->getClass());

        $query = $em
            ->createQueryBuilder()
            ->select('node')
            ->from($this->admin->getClass(), 'node')
            ->orderBy('node.root, node.lft', 'ASC')
            ->getQuery();
        $repo->setChildrenIndex('children');
        $tree = $repo->buildTree($query->getArrayResult(), array('decorate' => false));


        $data = $this->get('serializer')->serialize($tree, 'json');

        return new Response($data);
    }

//    /**
//     * @param integer $id
//     *
//     * @return \Symfony\Bundle\FrameworkBundle\Controller\RedirectResponse
//     */
//    public function moveUpAction($id)
//    {
//        /**
//         * @var \Sonata\DoctrineORMAdminBundle\Model\ModelManager  $modelManager
//         * @var MenuNode                                           $node
//         * @var \Gedmo\Tree\Entity\Repository\NestedTreeRepository $modelRepository
//         */
//        $modelManager = $this->admin->getModelManager();
//        $node = $modelManager->find($this->admin->getClass(), $id);
//        $modelRepository = $this->admin->getEntityManager()->getRepository();
//
//        $modelRepository->moveUp($node);
//
//        return $this->redirect($this->admin->generateUrl('list'));
//    }
}