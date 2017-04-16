<?php
namespace AppBundle\Form;

use AppBundle\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $object= $event->getData();
            $form = $event->getForm();

            if ($object->getId() == null && $object->getDescription() == null) {
                $form->add('name', null)
                    ->add('value', null)
                    ->add('save', SubmitType::class);
            }else{
                $form->add('value', TextType::class, array('property_value' => 'value',
                    'property_name' => 'name',
                    'property_description' => 'description',
                    'label' => false))
                ;
            }
        });

//        $builder
//            ->add('value', TextType::class, array('property_value' => 'value',
//                'property_name' => 'name',
//                'property_description' => 'description',
//                'label' => false))
////            ->add('type')
////            ->add('value')
//
////            ->add('save', SubmitType::class)
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Property::class,
            'property' => null
        ));
    }
}