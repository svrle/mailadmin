<?php
namespace AppBundle\Form;

use AppBundle\Entity\Domain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'domain.form.name'))
            ->add('defaultQuota', null, array('attr' => array('min' => 0, 'max' => 1024), 'label' => 'domain.form.quota'))
            ->add('emailNumbers', null, array('attr' => array('min' => 0, 'max' => 1024), 'label' => 'domain.form.email_numbers'))
            ->add('save', SubmitType::class, array('label' => 'domain.form.btn_save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Domain::class,
        ));
    }
}