<?php

namespace MFB\CmsBundle\Controller;

use MFB\CmsBundle\Entity\Types\MenuNodeLinkTypeType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use MFB\CmsBundle\Entity\Gallery;
use MFB\CmsBundle\Entity\Media;
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
 * MediaAdminController
 */
class MediaAdminController extends Controller
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
            'MFBCmsBundle:MediaAdmin:list.html.twig', array(
            'action' => 'list'
        ));
    }
    /**
     * return the Response object associated to the list action
     *
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function createAction()
    {
        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        return $this->render(
            'MFBCmsBundle:MediaAdmin:create.html.twig', array(
            'action' => 'create'
        ));
    }

    /**
     * @throws AccessDeniedException
     *
     * @return Response
     */
    public function ajaxUploadAction()
    {
        if (false === $this->admin->isGranted('EDIT')) {
            throw new AccessDeniedException();
        }

        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($this->admin->getClass());

        $em->flush();

        return new Response(json_encode(true));
    }


}