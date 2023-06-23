<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SportifAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('nom')
            ->add('prenom')
            ->add('sport', EntityType::class, [
                'class' => 'App\Entity\Sport',
                'choice_label' => 'nom',
            ])
            ->add('delegation', EntityType::class, [
                'class' => 'App\Entity\Delegation',
                'choice_label' => 'nom',
            ])
            ->add('evenements', EntityType::class, [
                'class' => 'App\Entity\Evenement',
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('actualites', EntityType::class, [
                'class' => 'App\Entity\Actualite',
                'choice_label' => 'titre',
                'multiple' => true,
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('nom')
            ->add('prenom')
            ->add('sport')
            ->add('delegation')
            ->add('evenements')
            ->add('actualites')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('nom')
            ->add('prenom')
            ->add('sport')
            ->add('delegation')
            ->add('evenements')
            ->add('actualites')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('nom')
            ->add('prenom')
            ->add('sport')
            ->add('delegation')
            ->add('evenements')
            ->add('actualites')
        ;
    }

}