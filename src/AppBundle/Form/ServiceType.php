<?php
namespace AppBundle\Form;

use AppBundle\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('value', TextType::class, array('property_value' => 'value',
//                'property_name' => 'name',
//                'property_description' => 'description',
//                'label' => false))
            ->add('name')
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'inet' => 'inet',
                    'unix' => 'unix',
                    'fifo' => 'fifo',
                    'pass' => 'pass'
                )
            ))
            ->add('private', ChoiceType::class, array(
                'data' => '-',
                'choices' => array(
                    'Yes' => 'y',
                    'No' => 'n',
                    'Default' => '-'
                )
            ))
            ->add('unpriv', ChoiceType::class, array(
                'data' => '-',
                'choices' => array(
                    'Yes' => 'y',
                    'No' => 'n',
                    'Default' => '-'
                )
            ))
            ->add('chroot', ChoiceType::class, array(
                'data' => '-',
                'choices' => array(
                    'Yes' => 'y',
                    'No' => 'n',
                    'Default' => '-'
                )
            ))
            ->add('wakeup', ChoiceType::class, array(
                'data' => '-',
                'choices' => array(
                    'Yes' => 'y',
                    'No' => 'n',
                    'Default' => '-'
                )
            ))
            ->add('maxproc')
            ->add('command')
//            ->add('value')

            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Service::class,
        ));
    }
}