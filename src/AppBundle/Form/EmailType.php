<?php
namespace AppBundle\Form;

use AppBundle\Entity\Email;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
    protected $email;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->email = $options['email'];
        $builder
            ->add('username', null, array('label' => 'email.form.username'))
            ->add('name', null, array('label' => 'email.form.name'))
            ->add('surname', null, array('label' => 'email.form.surname'))
            ->add('password', null, array('label' => 'email.form.password'))
            ->add('quota', null, array('label' => 'email.form.quota'))
            ->add('aliases', null, array('label' => 'email.form.alias',
                'class' => 'AppBundle\Entity\Email',
                'query_builder' => function(EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('o')
                    ->where('o.domain = :domain')->setParameter('domain', $this->email->getDomain())
                    ->andWhere('o.quota is null');
            }))
            ->add('save', SubmitType::class, array('label' => 'email.form.btn_save'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Email::class,
            'email' => null
        ));
    }
}