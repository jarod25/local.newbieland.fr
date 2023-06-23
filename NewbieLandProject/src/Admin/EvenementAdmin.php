<?php

namespace App\Admin;

use App\Entity\Sport;
use App\Entity\Sportif;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EvenementAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form) : void
    {
        $form
            ->add('nom')
            ->add('debut', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('fin', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('ville', EntityType::class, [
                'class' => 'App\Entity\Ville',
                'choice_label' => 'libelle',
            ])
            ->add('actualites', EntityType::class, [
                'class' => 'App\Entity\Actualite',
                'choice_label' => 'titre',
                'multiple' => true
            ])
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom',
            ])
            ->add('sportifs', EntityType::class, [
                'class' => Sportif::class,
                'choice_label' =>
                    function ($sportif) {
                        return $sportif->getNom() . ' ' . $sportif->getPrenom();
                    },
                'multiple' => true
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('nom')
            ->add('debut')
            ->add('fin')
            ->add('ville')
            ->add('sport')
            ->add('sportifs')
            ->add('actualites')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('nom')
            ->add('debut')
            ->add('fin')
            ->add('ville')
            ->add('sport')
            ->add('sportifs')
            ->add('actualites')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('nom')
            ->add('debut')
            ->add('fin')
            ->add('ville')
            ->add('sport')
            ->add('sportifs')
            ->add('actualites')
        ;
    }

}