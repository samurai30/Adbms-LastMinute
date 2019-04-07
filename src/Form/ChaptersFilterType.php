<?php

namespace App\Form;

use App\Entity\Chapters;
use App\Repository\ChaptersRepository;
use App\Repository\SubjectsRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaptersFilterType extends AbstractType
{

    /**
     * @var ChaptersRepository
     */
    private $chapRepository;

    /**
     * ChaptersFilterType constructor.
     * @param ChaptersRepository $chapRepository
     */
    public function __construct(ChaptersRepository $chapRepository)
    {
         $this->chapRepository = $chapRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('subject', StudentFilterType::class,[
                'add_shared' => function (FilterBuilderExecuterInterface $qbe){
                    $closure = function (QueryBuilder $filterBuilder,$alias,$joinAlias,Expr $expr){
                        $filterBuilder->leftJoin($alias.'.subject',$joinAlias);
                    };
                    $qbe->addOnce($qbe->getAlias().'.subject','opt2',$closure);
                },
                'user' => $options['user'],
                'label' => false
            ])
        ;

        $builder->get('subject')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $form->getParent()->add('chapterName', ChoiceFilterType::class,[
                    'label' => 'Chapters',
                    'required' => true,
                    'choices' => $this->chapRepository->getChapBySub($form->getData()->getSubName())
                ]);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chapters::class,
            'user' => null,
            'subName' => null
        ]);
    }
    public function getParent()
    {
        return SharedableFilterType::class;
    }
}
