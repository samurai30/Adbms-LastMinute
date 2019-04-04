<?php


namespace App\Admin;


use App\Entity\Courses;
use App\Entity\Semester;
use function Sodium\add;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubjectsAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form)
    {

        $form->add('subName',TextType::class)
            ->add('course',EntityType::class,[
                'class' => Courses::class
            ])
            ->add('sem',EntityType::class,[
                'class'=> Semester::class

            ]);

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('subName')
        ->add('course');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('subName')
            ->add('course','many_to_one')
            ->add('sem','many_to_one');
    }


}