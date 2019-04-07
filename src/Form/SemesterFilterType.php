<?php

namespace App\Form;

use App\Entity\Semester;
use App\Repository\SemesterRepository;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SemesterFilterType extends AbstractType
{

    /**
     * @var SemesterRepository
     */
    private $repository;

    public function __construct(SemesterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SemName',ChoiceFilterType::class,[
                'choices' => $this->repository->getSemester()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Semester::class,
        ]);
    }
    public function getParent()
    {
        return SharedableFilterType::class;
    }
}
