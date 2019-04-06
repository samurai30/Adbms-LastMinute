<?php

namespace App\Form;

use App\Entity\Chapters;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaptersFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chapterName',TextFilterType::class)
            ->add('subject', StudentFilterType::class,[
                'add_shared' => function (FilterBuilderExecuterInterface $qbe){
                    $closure = function (QueryBuilder $filterBuilder,$alias,$joinAlias,Expr $expr){
                        $filterBuilder->leftJoin($alias.'.subject',$joinAlias);
                    };
                    $qbe->addOnce($qbe->getAlias().'.subject','opt2',$closure);
                },
                'user' => $options['user']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chapters::class,
            'user' => null
        ]);
    }
    public function getParent()
    {
        return SharedableFilterType::class;
    }
}
