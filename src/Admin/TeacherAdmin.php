<?php


namespace App\Admin;


use App\Entity\Courses;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TeacherAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('course',EntityType::class,[
                'class' => Courses::class
            ])
            ->add('firstName',TextType::class)
            ->add('lastName',TextType::class)
            ->add('username',TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Password confirmation')
            ))
            ->add('email',EmailType::class)
            ->add('gender', ChoiceType::class,[
                'choices' => [
                    'male' => 'male',
                    'female' => 'female'
                ]
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('username');
    }

    protected function configureListFields(ListMapper $list)
    {
       $list->add('username');
    }

    public function prePersist($object)
    {
        $plainPassword = $object->getPlainPassword();
        $container = $this->getConfigurationPool()->getContainer();
        $encoder = $container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($object, $plainPassword);
        $object->setPassword($encoded);
    }
}