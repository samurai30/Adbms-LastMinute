<?php

namespace App\Form;

use App\Entity\Chapters;
use App\Entity\Questions;
use App\Entity\Subjects;
use App\Repository\SubjectsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddQuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $options['user'];
        $builder
            ->add('question',TextareaType::class)
            ->add('marks', IntegerType::class,[
                'attr' => ['max' =>'15']
            ])
            ->add('answers',TextareaType::class)
            ->add('Year', ChoiceType::class,[
                'choices' => $this->buildYearChoices(),
                'mapped' => false
            ])
            ->add('subjects',EntityType::class,[
                 'class' => Subjects::class,
                 'query_builder' => function(SubjectsRepository $subjectsRepository) use($options){
                    return $subjectsRepository->createQueryBuilder('c')
                        ->where('c.course = :val')
                        ->setParameter('val', $options['user']->getCourse()->getId());
                 },
                 'mapped' => false,
            ])
            ->add('submit',SubmitType::class,[
                'attr' => ['class'=>'btn right btn-large orange lighten-3',
                    'style' => 'font-weight: bold'],
                'label' => 'ADD'
            ])
        ;
        $builder->get('subjects')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                dump($form);
                $form->getParent()->add('chapter',EntityType::class,[
                    'class' => Chapters::class,
                ]);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
            'user' => null
        ]);
    }

    /**
     * @return array|false
     */
    public function buildYearChoices() {
        $distance = 15;
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distance));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 0));
        return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }
}
