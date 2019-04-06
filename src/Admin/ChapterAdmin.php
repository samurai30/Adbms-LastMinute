<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 06-04-2019
 * Time: 05:51 PM
 */

namespace App\Admin;


use App\Entity\Subjects;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChapterAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
       $form->add('chapterName',TextType::class)
           ->add('subject',EntityType::class,[
               'class' => Subjects::class
           ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('chapterName')
            ->add('subject');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('chapterName')
            ->add('subject', 'many_to_one');
        }

}