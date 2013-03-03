<?php

namespace MFB\CmsBundle\Controller;

use MFB\CmsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
class NewsController extends Controller
{

    /**
     * @Route("news/archiv", name="news_archive")
     * @Route("news", name="news_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $query \Doctrine\ORM\Query */
        $query = $em->createQuery(
            'SELECT n FROM MFBCmsBundle:News n WHERE n.active = 1 ORDER BY n.releasedAt DESC'
        );
        $query->execute();

        $news = $query->getResult();

        return array('news' => $news);
    }

    /**
     * @Route("news/show/{id}", name="news_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('MFBCmsBundle:News');
        /** @var News $news */
        $news = $repo->find($id);

        if ($news->getActive() != true) {
            throw new NotFoundHttpException;
        }

        return array('news' => $news);
    }
}
