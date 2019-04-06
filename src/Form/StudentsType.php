<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\Students;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => ['attr' =>  ['placeholder' => 'password'],
                    'label' => false],
                'second_options' => ['attr' => ['placeholder' => 'confirm password']
                    , 'label' => false]
            ])
            ->add('gender',ChoiceType::class,[
                'choices' =>[
                    'male' => 'male',
                    'female' => 'female'
                ]
            ])
            ->add('course',EntityType::class,[
                'class' => Courses::class
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Register',
                'attr' => ['class' => 'btn btn-large right deep-purple lighten-1']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
