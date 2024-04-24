<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class VilleAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form) : void
    {
        $form
            ->add('libelle')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('libelle')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('libelle')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('libelle')
        ;
    }

}