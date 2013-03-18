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
class CategoryAdmin extends Admin
{
    /**
     * The label class name  (used in the title/breadcrumb ...)
     *
     * @var string
     */
    protected $classnameLabel = 'category';

    /**
     * The base route pattern used to generate the routing information
     *
     * @var string
     */
    protected $baseRoutePattern = 'cms/category';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('active')
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
            ->add('title', null, array('required' => true))
            ->add('active', null, array('required' => false))
            ->end();
    }
}
