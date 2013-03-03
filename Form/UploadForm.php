<?php
namespace MFB\CmsBundle\Form;

use MFB\CmsBundle\Entity\Types\MediaParentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @category   MFB
 * @package    MFBExampleBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */
class UploadForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden', array('required' => false));
        $builder->add('search', 'text', array('required' => false));
        $builder->add('parentType', 'choice', array('choices' => MediaParentType::getChoices()));
    }

    public function getName()
    {
        return 'upload';
    }
}