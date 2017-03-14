<?php
namespace AppBundle\Form;

use AppBundle\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'email.form.username'))
            ->add('name', null, array('label' => 'email.form.name'))
            ->add('surname', null, array('label' => 'email.form.surname'))
            ->add('password', null, array('label' => 'email.form.password'))
            ->add('quota', null, array('label' => 'email.form.quota'))
            ->add('save', SubmitType::class, array('label' => 'email.form.btn_save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Email::class,
        ));
    }
}