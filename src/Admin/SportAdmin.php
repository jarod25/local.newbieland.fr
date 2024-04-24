<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SportAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('nom')
            ->add('description', TextareaType::class)
            ->add('imageFile', FileType::class, [
                'required' => false,
            ])
            ->add('sportifs', EntityType::class, [
                'class' => 'App\Entity\Sportif',
                'multiple' => true,
            ])
            ->add('evenements', EntityType::class, [
                'class' => 'App\Entity\Evenement',
                'multiple' => true,
                'required' => false,
            ])
            ->add('actualites', EntityType::class, [
                'class' => 'App\Entity\Actualite',
                'multiple' => true,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('nom')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('nom')
            ->add('description')
            ->add('imageName')
            ->add('sportifs')
            ->add('evenements')
            ->add('actualites')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('nom')
            ->add('description')
            ->add('imageName')
            ->add('sportifs')
            ->add('evenements')
            ->add('actualites')
        ;
    }

}