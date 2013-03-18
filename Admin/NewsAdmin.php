<?php
namespace MFB\CmsBundle\Admin;

use MFB\CmsBundle\Entity\User;
use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Form\FormMapper,
    Sonata\AdminBundle\Datagrid\ListMapper;

use MFB\CmsBundle\Entity\News;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 */
class NewsAdmin extends Admin
{
    /**
     * The label class name  (used in the title/breadcrumb ...)
     *
     * @var string
     */
    protected $classnameLabel = 'news';

    /**
     * The base route pattern used to generate the routing information
     *
     * @var string
     */
    protected $baseRoutePattern = '/news';

    /** @var \Symfony\Component\Security\Core\SecurityContext */
    protected $securityContext;

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('releasedAt')
            ->add('category')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('releasedAt', null, array('required' => true))
            ->add('title', null, array('required' => true))
            ->add('subTitle', null, array('required' => false))
            ->add('active', null, array('required' => false))
            ->add('category', null, array('required' => true))
            ->add('content', null, array(
                'required' => false,
                'attr' => array(
                    'class'      => 'wysiwyg',
                    'data-theme' => 'advanced'
                )
            ))
            ->end();
        $formMapper->setHelps(array(
                'content' =>
                $this->trans('Formatting with markdown & html. See ')
                    . '<a target="_blank" href="http://'
                    . $this->trans('daringfireball.net/projects/markdown/basics')
                    . '">'
                    . $this->trans('help')
                    . '</a>'
            )
        );
    }

    /**
     * @param News $object
     *
     * @return News
     */
    public function prePersist($object)
    {
        if (!($object->getAuthor() instanceof User)) {
            $user = $this->getSecurityContext()->getToken()->getUser();
            $object->setAuthor($user);
        }

        return $object;
    }

    /**
     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     */
    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }
}
