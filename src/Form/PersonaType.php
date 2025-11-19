<?php

namespace App\Form;

use App\Entity\Persona;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('dni')
            ->add('fechaNacimiento', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Fecha',
            'attr' => ['class' => 'form-control'],
        ])
            ->add('genero', ChoiceType::class, [
            'choices' => [
                'Masculino' => 'Masculino',
                'Femenino' => 'Femenino',
                'Otro' => 'Otro',
            ],
            'placeholder' => 'Seleccione su genero',
            'label' => 'Género',
            'attr' => ['id' => 'genero']
        ])
            ->add('estadoCivil', ChoiceType::class, [
            'choices' => [
                'Soltero' => 'Soltero',
                'Casado' => 'Casado',
                'Divorciado' => 'Divorciado',
                'Viudo' => 'Viudo',
            ],
            'placeholder' => 'Seleccione su estado civil',
            'label' => 'Estado Civil',
            'attr' => ['id' => 'estadoCivil']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Persona::class,
        ]);
    }
}
