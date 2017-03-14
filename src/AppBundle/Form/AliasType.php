<?php
namespace AppBundle\Form;

use AppBundle\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AliasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'alias.form.username'))
            ->add('emails', null, array('label' => 'alias.form.emails'))
            ->add('save', SubmitType::class, array('label' => 'alias.form.btn_save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Email::class,
            'validation_groups' => array('alias')
        ));
    }
}