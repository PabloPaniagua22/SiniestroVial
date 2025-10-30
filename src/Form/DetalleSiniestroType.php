<?php

namespace App\Form;

use App\Entity\DetalleSiniestro;
use App\Entity\Persona;
use App\Entity\RolPersona;
use App\Entity\Siniestro;
use App\Entity\Vehiculo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetalleSiniestroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('estadoAlcoholico')
            ->add('porcentajeAlcohol')
            ->add('observaciones')
            ->add('rutaDocumento')
            ->add('siniestro', EntityType::class, [
                'class' => Siniestro::class,
                'choice_label' => 'id',
            ])
            ->add('persona', EntityType::class, [
                'class' => Persona::class,
                'choice_label' => 'id',
            ])
            ->add('rolPersona', EntityType::class, [
                'class' => RolPersona::class,
                'choice_label' => 'id',
            ])
            ->add('vehiculo', EntityType::class, [
                'class' => Vehiculo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetalleSiniestro::class,
        ]);
    }
}
