<?php

namespace App\Form;

use App\Entity\Vehiculo;
use App\Entity\Persona;
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
            ->add('vehiculo', EntityType::class, [
                'class' => Vehiculo::class,
                'choice_label' => function($v) {
                    return $v->getPatente() . ' - ' . $v->getMarca() . ' ' . $v->getModelo();
                },
                'placeholder' => 'Seleccione un vehículo',
                'label' => 'Vehículo involucrado',
                'attr' => ['class' => 'form-select']
            ])

            ->add('persona', EntityType::class, [
                'class' => Persona::class,
                'choice_label' => function($p) {
                    return $p->getApellido() . ' ' . $p->getNombre() . ' - DNI ' . $p->getDni();
                },
                'placeholder' => 'Seleccione el conductor / dueño',
                'label' => 'Persona vinculada al vehículo',
                'attr' => ['class' => 'form-select']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VehiculoSiniestro::class,
        ]);
    }
}
