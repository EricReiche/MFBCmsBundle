<?php

namespace MFB\CmsBundle\Controller;

use MFB\CmsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    const PAGER_LIMIT = 10;

    /**
     * @Route("news/archiv", name="news_archive")
     * @Route("news", name="news_list")
     * @Template()
     */
    public function listAction()
    {
        $page = $this->getRequest()->get('page', 1);
        if (!is_numeric($page)) {
            $page = 1;
        }

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('MFBCmsBundle:News')->createQueryBuilder('n');

        $qb
            ->leftJoin('n.category', 'c')
            ->andWhere('n.active = 1')
            ->orderBy('n.releasedAt', 'DESC');

        $query = $qb->getQuery();

        $paginator = $this->get('knp_paginator');
        /** @var \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination $news */
        $news = $paginator->paginate($query, $page, self::PAGER_LIMIT);
        $firstItem = current($news->getItems());

        return array('news' => $news, 'firstItem' => $firstItem);
    }

    /**
     * @Route("news/show/{news}", name="news_show")
     * @ParamConverter("news", options={"mapping": {"news": "slug"}})
     * @Template()
     */
    public function showAction(News $news)
    {
        if ($news->getActive() != true) {
            throw new NotFoundHttpException;
        }

        return array('news' => $news);
    }
}
