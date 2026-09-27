<?php

namespace App\Form;

use App\Entity\Fiche;
use App\Entity\LigneFiche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut', DateTimeType::class, [])
            ->add('date_fin', DateTimeType::class, [])
            ->add('heures_normal_mensuel', NumberType::class, [])
            ->add('heures_majorees_mensuel', NumberType::class, [])
            ->add('montant_deduction_periode_abs', MoneyType::class, [])
            ->add('montant_divers', MoneyType::class, [])
            ->add('montant_conges', MoneyType::class, [])
            ->add('conge_date_start', DateTimeType::class, [
                'required' => false,
            ])
            ->add('conge_date_end', DateTimeType::class, [
                'required' => false,
            ])
            ->add('ligneFiches', CollectionType::class, [
                'entry_type' => LigneFicheType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'prototype_name' => '__name__', // valeur par défaut, explicite ici
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fiche::class,
            'attr' => [
                'class' => '',
            ]
        ]);
    }
}
