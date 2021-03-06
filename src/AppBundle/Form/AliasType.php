<?php
namespace AppBundle\Form;

use AppBundle\Entity\Email;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AliasType extends AbstractType
{
    protected $domain;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->domain = $options['domain'];
        $builder
            ->add('username', null, array('label' => 'alias.form.username'))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $object = $event->getData();
            $form = $event->getForm();


            if ($object->getDomain()->getCountOnlyEmails() >= 1) {
                $form->add('emails', null, array('label' => 'alias.form.emails',
                    'class' => 'AppBundle\Entity\Email',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('o')
                            ->where('o.domain = :domain')->setParameter('domain', $this->domain)
                            ->andWhere('o.password is not null');
                    }
                ));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Email::class,
            'validation_groups' => array('alias'),
            'domain' => null
        ));
    }
}