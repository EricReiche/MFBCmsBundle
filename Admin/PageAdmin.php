<?php
namespace MFB\CmsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Form\FormMapper,
    Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 */
class PageAdmin extends Admin
{
    /**
     * The label class name  (used in the title/breadcrumb ...)
     *
     * @var string
     */
    protected $classnameLabel = 'page';

    /**
     * The base route pattern used to generate the routing information
     *
     * @var string
     */
    protected $baseRoutePattern = '/pages';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('releasedAt')
            ->add('slug')
            ->add('active', null, array('required' => false))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
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
            ->add('slug', null, array('required' => false, 'attr' => array('readonly' => true)))
            ->add('active', null, array('required' => false))
            ->add('content', null, array('required' => true))
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
}
