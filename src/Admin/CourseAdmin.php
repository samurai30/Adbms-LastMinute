<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CourseAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form)
    {

            $form->add('courseName',TextType::class)
                ->add('subjects',CollectionType::class,[
                    'by_reference' => false,
                ],[
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ]);


          }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('courseName');
     }

    protected function configureListFields(ListMapper $list)
    {

        $list->addIdentifier('courseName');


     }

}