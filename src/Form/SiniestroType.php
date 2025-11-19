<?php

namespace App\Form;

use App\Entity\Siniestro;
use App\Entity\Usuario;
use App\Form\DetalleSiniestroType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SiniestroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha',
                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('hora', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Hora',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('descripcion')
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Validado' => 'Validado',
                    'En investigación' => 'En investigación',
                    'Archivado' => 'Archivado',
                ],
                'placeholder' => 'Seleccione el estado',
                'label' => 'Estado del siniestro',
            ])

            ->add('severidad', ChoiceType::class, [
                'choices' => [
                    'Leve' => 'Leve',
                    'Grave' => 'Grave',
                    'Fatal' => 'Fatal',
                ],
                'placeholder' => 'Seleccione la severidad',
                'label' => 'Severidad del siniestro',
            ])
            ->add('localidad')
            ->add('calle')
            ->add('coordenadas')
            ->add('nroActa')
            ->add('Usuario', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'nombre',
            ])

            ->add('detalleSiniestros', CollectionType::class, [
                'entry_type' => DetalleSiniestroType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => false
            ])

            ->add('vehiculoSiniestros', CollectionType::class, [
                'entry_type' => VehiculoSiniestroType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Siniestro::class,
        ]);
    }
}
