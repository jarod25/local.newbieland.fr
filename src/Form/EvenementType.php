<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Sport;
use App\Entity\Sportif;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('debut', DateType::class)
            ->add('fin', DateType::class)
            ->add('sportifs', EntityType::class, [
                'class' => Sportif::class,
                'choice_label' =>
                    function ($sportif) {
                        return $sportif->getNom() . ' ' . $sportif->getPrenom();
                    },
                'multiple' => true
            ])
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom',
                'multiple' => false
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'libelle',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
