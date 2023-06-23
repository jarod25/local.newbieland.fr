<?php

namespace App\Form;

use App\Entity\Actualite;
use App\Entity\Delegation;
use App\Entity\Evenement;
use App\Entity\MedalsEnum;
use App\Entity\Sport;
use App\Entity\Sportif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SportifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom',
                'autocomplete' => true,
            ])
            ->add('delegation', EntityType::class, [
                'class' => Delegation::class,
                'choice_label' => 'nom',
                'autocomplete' => true,
            ])
            ->add('evenements', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'required' => false,
                'autocomplete' => true,
            ])
            ->add('actualites', EntityType::class, [
                'class' => Actualite::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'required' => false,
                'autocomplete' => true,
            ])
            ->add('medal', EnumType::class, [
                'class' => MedalsEnum::class,
                'label' => 'Medailles',
                'choice_label' => fn ($choice) => $choice->getLabel(),
                'autocomplete' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Remove Image',
                'download_label' => 'Download Image',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('palmares', CollectionType::class, [
                'entry_type' => PalmaresType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sportif::class,
        ]);
    }
}
