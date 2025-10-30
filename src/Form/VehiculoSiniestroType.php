<?php

namespace App\Form;

use App\Entity\Persona;
use App\Entity\Siniestro;
use App\Entity\Vehiculo;
use App\Entity\VehiculoSiniestro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoSiniestroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('siniestro', EntityType::class, [
                'class' => Siniestro::class,
                'choice_label' => 'id',
            ])
            ->add('vehiculo', EntityType::class, [
                'class' => Vehiculo::class,
                'choice_label' => 'id',
            ])
            ->add('persona', EntityType::class, [
                'class' => Persona::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VehiculoSiniestro::class,
        ]);
    }
}
