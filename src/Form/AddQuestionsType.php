<?php

namespace App\Form;

use App\Entity\Chapters;
use App\Entity\Questions;
use App\Repository\ChaptersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddQuestionsType extends AbstractType
{

    /**
     * @var ChaptersRepository
     */
    private $repository;

    /**
     * AddQuestionsType constructor.
     * @param EntityManagerInterface $repository
     */
    public function __construct(EntityManagerInterface $repository)
    {

        $this->repository = $repository;
    }

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
            ->add('chapter',ChoiceType::class,[
                'choices' => $this->repository->getRepository(Chapters::class)->getChapters($user->getCourse()->getId()),
                'mapped' => false
            ])
            ->add('submit',SubmitType::class,[
                'attr' => ['class'=>'btn right btn-large orange lighten-3',
                    'style' => 'font-weight: bold'],
                'label' => 'ADD'
            ])

        ;
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
