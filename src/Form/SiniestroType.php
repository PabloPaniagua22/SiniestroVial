<?php

namespace App\Form;

use App\Entity\Siniestro;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiniestroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha')
            ->add('hora')
            ->add('descripcion')
            ->add('severidad')
            ->add('estado')
            ->add('localidad')
            ->add('calle')
            ->add('coordenadas')
            ->add('nroActa')
            ->add('Usuario', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Siniestro::class,
        ]);
    }
}
