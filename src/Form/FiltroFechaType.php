<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltroFechaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_desde', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Fecha desde',
            ])
            ->add('fecha_hasta', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Fecha hasta',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
