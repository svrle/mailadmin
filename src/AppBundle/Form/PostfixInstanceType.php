<?php
namespace AppBundle\Form;

use AppBundle\Entity\Alias;
use AppBundle\Entity\PostfixInstance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostfixInstanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip')
            ->add('hostname')
            ->add('name')
//            ->add('defaultQuota', null, array('attr' => array('min' => 0, 'max' => 1024)))
//            ->add('emailNumbers', null, array('attr' => array('min' => 0, 'max' => 1024)))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PostfixInstance::class,
        ));
    }
}