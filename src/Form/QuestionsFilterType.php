<?php

namespace App\Form;

use App\Entity\Questions;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marks',IntegerType::class,[
                'required' => false
            ])
            ->add('chapter',ChaptersFilterType::class,[
                'add_shared' => function (FilterBuilderExecuterInterface $qbe){
                    $closure = function (QueryBuilder $filterBuilder,$alias,$joinAlias,Expr $expr){
                        $filterBuilder->leftJoin($alias.'.chapter',$joinAlias);
                    };
                    $qbe->addOnce($qbe->getAlias().'.chapter','opt1',$closure);
                },
                'user' => $options['user'],
                'label' => false
            ])
            ->add('tags')
            ->add('submit',SubmitType::class,[
                'attr' => ['class'=> 'btn btn-large red lighten-4 right'],
                'label' => 'Search'
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
}
