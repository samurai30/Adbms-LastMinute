<?php
/**
 * Created by PhpStorm.
 * User: Samurai
 * Date: 06-04-2019
 * Time: 10:19 AM
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SemesterAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form)
    {
            $form->add('SemName',TextType::class);
        }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('SemName');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('SemName');
    }

}