<?php

namespace MFB\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MFB\CmsBundle\Entity\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
class PageController extends Controller
{
    /**
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('MFBCmsBundle:Page');
        $content = $repo->findOneBy(array('slug' => $slug));
        if ($content instanceof Page) {
            return array('page' => $content);
        }
        throw new NotFoundHttpException();
    }
}
