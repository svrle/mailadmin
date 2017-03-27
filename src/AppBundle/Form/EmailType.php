<?php
namespace AppBundle\Form;

use AppBundle\Entity\Email;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
    protected $email;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->email = $options['email'];
        $builder
            ->add('username', null, array('label' => 'email.form.username'))
//            ->add('plainPassword', RepeatedType::class, array(
//                'type' => PasswordType::class,
//                'first_options'  => array('label' => 'Password'),
//                'second_options' => array('label' => 'Repeat Password'),
//            ))
            ->add('name', null, array('label' => 'email.form.name'))
            ->add('surname', null, array('label' => 'email.form.surname'))
            ->add('quota', null, array('label' => 'email.form.quota'))
            ->add('aliases', null, array('label' => 'email.form.alias',
                'class' => 'AppBundle\Entity\Email',
                'query_builder' => function(EntityRepository $entityRepository) {
                $form = $entityRepository->createQueryBuilder('o')
                    ->where('o.domain = :domain')->setParameter('domain', $this->email->getDomain())
                    ->andWhere('o.quota is null');
                    if($this->email->getId())
                    {
                        $form->andWhere('o != :thisEmail')->setParameter('thisEmail', $this->email);
                    }
                    return $form;
            }))
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $object= $event->getData();
            $form = $event->getForm();

            if ($object->getId() != null) {
                $form->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Password', 'required' => false),
                    'second_options' => array('label' => 'Repeat Password', 'required' => false),
                    'required' => false,
                    'mapped' => false,
                    'empty_data' => null
                ));
            }else{
                $form->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ));
            }
        });
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            $object= $event->getData();
//            $form = $event->getForm();
//
//            if ($object->getId() != null) {
//                $form->add('aliases', null, array('label' => 'email.form.alias',
////                'choices' => $this->email->getFullEmail(),
//                    'class' => 'AppBundle\Entity\Email',
//                    'query_builder' => function(EntityRepository $entityRepository) {
//                        return $entityRepository->createQueryBuilder('o')
//                            ->where('o.domain = :domain')->setParameter('domain', $this->email->getDomain())
//                            ->andWhere('o.quota is null')
//                    ->andWhere('o != :thisEmail')->setParameter('thisEmail', $this->email)
//                            ;
//                    }));
//            }else{
//                $form->add('aliases', null, array('label' => 'email.form.alias',
////                'choices' => $this->email->getFullEmail(),
//                    'class' => 'AppBundle\Entity\Email',
//                    'query_builder' => function(EntityRepository $entityRepository) {
//                        return $entityRepository->createQueryBuilder('o')
//                            ->where('o.domain = :domain')->setParameter('domain', $this->email->getDomain())
//                            ->andWhere('o.quota is null')
////                    ->andWhere('o != :thisEmail')->setParameter('thisEmail', $this->email)
//                            ;
//                    }));
//            }
//        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Email::class,
            'email' => null
        ));
    }
}