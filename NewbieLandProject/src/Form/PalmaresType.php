<?php

namespace App\Form;

use App\Entity\Palmares;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\MedalsEnum;

class PalmaresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('competition', TextType::class)
            ->add('position', EnumType::class, [
                'class' => MedalsEnum::class,
                'choice_label' => 'label',
                'placeholder' => 'Choisir une position',
                'autocomplete' => true,
            ])
            ->add('annee', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Palmares::class,
        ]);
    }
}
