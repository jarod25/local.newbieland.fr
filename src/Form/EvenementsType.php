<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;

class EvenementsType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'empty_data' => '2023-01-01',
            ])
            ->add('fin', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'empty_data' => '2023-12-31',
            ])
            ->add('sport', EntityType::class, [
                'class' => Sport::class,
                'required' => false,
                'choice_label' => 'nom',
                'placeholder' => 'Tous les sports',
                'autocomplete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
            'method' => 'GET',
        ]);
    }
}
