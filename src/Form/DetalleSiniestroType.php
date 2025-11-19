<?php

namespace App\Form;

use App\Entity\DetalleSiniestro;
use App\Entity\Persona;
use App\Entity\RolPersona;
use App\Entity\Vehiculo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DetalleSiniestroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('persona', PersonaType::class, [
                'label' => 'Datos de la Persona',
            ])

            ->add('vehiculo', VehiculoType::class, [
                'label' => false,
            ])

            ->add('rolPersona', EntityType::class, [
                'class' => RolPersona::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione un rol',
                'label' => 'Rol de la persona',
                'attr' => ['class' => 'form-select']
            ])

            ->add('estadoAlcoholico', ChoiceType::class, [
                'choices' => [
                    'Negativo' => 'Negativo',
                    'Positivo' => 'Positivo',
                ],
                'placeholder' => 'Seleccione un estado',
                'label' => 'Estado alcohólico',
                'attr' => ['class' => 'form-select']
            ])

            ->add('porcentajeAlcohol', NumberType::class, [
                'label' => 'Porcentaje de alcohol (%)',
                'required' => false,
                'scale' => 2,
                'attr' => [
                    'class' => 'form-control',
                    'min' => 0,
                    'step' => 0.01,
                ],
            ])

            ->add('observaciones', null, [
                'label' => 'Observaciones',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])

            ->add('rutaDocumento', FileType::class, [
                'label' => 'Documento (PDF o imagen)',
                'mapped' => false,
                'required' => false,
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
