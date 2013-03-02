<?php

namespace MFB\CmsBundle\Controller;

use MFB\CmsBundle\Entity\Types\MenuNodeLinkTypeType;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

use MFB\CmsBundle\Entity\Gallery;
use MFB\CmsBundle\Entity\Media;
use MFB\CmsBundle\Service\GalleryService;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
            'action' => 'create',
            'maxSize' => UploadedFile::getMaxFilesize() / 1024 / 1024
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

        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');
        if (null === $uploadedFile) {
            return new Response(json_encode(false));
        }
        /** @var GalleryService $galleryService */
        $galleryService = $this->get('mfb_cms.service.gallery');

        $uploadResponse = $galleryService->handleUpload($uploadedFile);

        if (isset($uploadResponse['error'])) {
            return new Response($uploadResponse['error'], 500);
        }

        return new Response(json_encode(true));
    }
}