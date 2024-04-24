<?php

namespace App\Admin;

use App\Entity\Actualite;
use App\Entity\Evenement;
use App\Entity\Sport;
use App\Entity\Sportif;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ActualiteAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $form) : void
    {
        $form
            ->add('titre', TextType::class)
            ->add('texte', TextareaType::class)
            ->add('published', CheckboxType::class, [
                'required' => false
            ])
            ->add('publish_date', DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                ]
            )
            ->add('sportifs', EntityType::class, [
                'class' => Sportif::class,
                'choice_label' =>
                    function ($sportif) {
                        return $sportif->getNom() . ' ' . $sportif->getPrenom();
                    },
                'multiple' => true
            ])
            ->add('evenements', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'nom',
                'multiple' => true
            ])
            ->add('sports', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom',
                'multiple' => true
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('titre')
            ->add('texte')
            ->add('published')
            ->add('publish_date')
            ->add('sportifs')
            ->add('evenements')
            ->add('sports')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('titre')
            ->add('texte')
            ->add('published')
            ->add('publish_date')
            ->add('sportifs')
            ->add('evenements', null, [
                'associated_property' => 'nom'
            ])
            ->add('sports')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('titre')
            ->add('texte')
            ->add('published')
            ->add('publish_date')
            ->add('sportifs')
            ->add('evenements')
            ->add('sports')
        ;
    }

}