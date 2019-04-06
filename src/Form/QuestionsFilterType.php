<?php

namespace App\Form;

use App\Entity\Questions;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marks')
            ->add('chapter',ChaptersFilterType::class,[
                'add_shared' => function (FilterBuilderExecuterInterface $qbe){
                    $closure = function (QueryBuilder $filterBuilder,$alias,$joinAlias,Expr $expr){
                        $filterBuilder->leftJoin($alias.'.chapter',$joinAlias);
                    };
                    $qbe->addOnce($qbe->getAlias().'.chapter','opt1',$closure);
                },
                'user' => $options['user']
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
            'user' => null
        ]);
    }
}
