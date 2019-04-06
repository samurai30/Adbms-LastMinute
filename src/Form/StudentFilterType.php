<?php

namespace App\Form;

use App\Entity\Subjects;
use App\Repository\SubjectsRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentFilterType extends AbstractType
{
    /**
     * @var SubjectsRepository
     */
    private $repository;

    /**
     * StudentFilterType constructor.
     * @param SubjectsRepository $repository
     */
    public function __construct(SubjectsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('subName',ChoiceFilterType::class,[
                    'choices' => $this->repository->getSubject($user->getCourse()->getId())
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subjects::class,
            'user' => null
        ]);
    }
    public function getParent()
    {
        return SharedableFilterType::class;
    }
}
