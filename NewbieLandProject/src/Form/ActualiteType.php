<?php

namespace App\Form;

use App\Entity\Actualite;
use App\Entity\Evenement;
use App\Entity\Sport;
use App\Entity\Sportif;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('texte', TextType::class)
            ->add('published', CheckboxType::class, [
                'required' => false
            ])
            ->add('publish_date', DateType::class)
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
