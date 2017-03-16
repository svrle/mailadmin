<?php
namespace AppBundle\Form;

use AppBundle\Entity\Domain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $object= $event->getData();
            $form = $event->getForm();

            if ($object->getId() != null) {
                $form->add('name', null, array('disabled' => true));
            }else{
                $form->add('name', null, array('label' => 'domain.form.name'));
            }
        });
        $builder
            ->add('defaultQuota', null, array('attr' => array('min' => 0, 'max' => 1024), 'label' => 'domain.form.quota'))
            ->add('emailNumbers', null, array('attr' => array('min' => 0, 'max' => 1024), 'label' => 'domain.form.email_numbers'))
            ->add('aliasNumbers', null, array('attr' => array('min' => 0, 'max' => 1024), 'label' => 'domain.form.alias_numbers'))
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