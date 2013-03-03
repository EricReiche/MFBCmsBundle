<?php
namespace MFB\CmsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Form\FormMapper,
    Sonata\AdminBundle\Datagrid\ListMapper;

use MFB\CmsBundle\Entity\Block;

use MFB\CmsBundle\Entity\Types\BlockTypeType,
    MFB\CmsBundle\Entity\Types\StatusType;

use MFB\CmsBundle\Service\CmsBlockService;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 */
class BlockAdmin extends Admin
{
    /**
     * The label class name  (used in the title/breadcrumb ...)
     *
     * @var string
     */
    protected $classnameLabel = 'block';

    /**
     * The base route pattern used to generate the routing information
     *
     * @var string
     */
    protected $baseRoutePattern = '/blocks';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('slug')
            ->add('title')
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
                ->add('slug', null, array('required' => true))
                ->add('title', null, array('required' => true))
                ->add('content', null, array('required' => true))
                ->add('type', 'choice', array(
                    'label' => 'Type',
                    'choices' => BlockTypeType::getChoices(),
                    'required'  => true,
                ))
                ->add('active')
            ->end();
    }

    /**
     * @return CmsBlockService
     */
    protected function getBlockService()
    {
        return $this->get('mfb_cms.service.cms_block');
    }

    /**
     * Gets a service.
     *
     * @param string $id The service identifier
     *
     * @return object The associated service
     */
    protected function get($id)
    {
        return $this->configurationPool->getContainer()->get($id);
    }
}