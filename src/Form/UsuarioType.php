<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\RolPersona;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('email')
            ->add('contrasena')
            ->add('rol', ChoiceType::class, [
                'choices' => [
                    'Administrador' => 'ROLE_ADMIN',
                    'Operador' => 'ROLE_OPERADOR',
                    'Policía' => 'ROLE_POLICIA',
                ],
                'label' => 'Rol del Sistema',
                'placeholder' => 'Seleccione un rol...',
            ])
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Activo' => 'activo',
                    'Inactivo' => 'inactivo',
                ],
                'label' => 'Estado',
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Seleccione estado...',
            ])
            ->add('contrasena', PasswordType::class, [
                'label' => 'Contraseña',
                'mapped' => true, // importante, ya que el campo existe en Usuario
                'attr' => ['autocomplete' => 'new-password'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
