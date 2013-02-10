<?php

namespace MFB\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
 * Press release frontend controller
 */
class PressController extends Controller
{

    /**
     * @Route("presse/archiv", name="pressrelease_list")
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $query \Doctrine\ORM\Query */
        $query = $em->createQuery(
            'SELECT p FROM MFBCmsBundle:PressRelease p ORDER BY p.releasedAt DESC'
        );
        $query->execute();

        $release = $query->getResult();

        return array('pressreleases' => $release);
    }

    /**
     * @Route("presse/aktuell", name="pressrelease_current")
     * @Template()
     */
    public function currentAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $query \Doctrine\ORM\Query */
        $query = $em->createQuery(
            'SELECT p FROM MFBCmsBundle:PressRelease p ORDER BY p.releasedAt DESC'
        );
        $query->setFirstResult(0)->setMaxResults(1)->execute();

        $release = $query->getSingleResult();

        return array('pressrelease' => $release);
    }
}
