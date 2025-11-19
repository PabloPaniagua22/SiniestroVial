<?php

namespace App\Form;

use App\Entity\Vehiculo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VehiculoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Moto' => 'Moto',
                    'Auto' => 'Auto',
                    'Camión' => 'Camión',
                    'Otro' => 'Otro',
                ],
                'placeholder' => 'Seleccione el tipo',
                'label' => 'Tipo de vehículo',
            ])
            ->add('patente')
            ->add('marca', ChoiceType::class, [
                    'choices' => [
                        'Volkswagen' => 'Volkswagen',
                        'Fiat' => 'Fiat',
                        'Ford' => 'Ford',
                        'Chevrolet' => 'Chevrolet',
                        'Toyota' => 'Toyota',
                        'Honda' => 'Honda',
                        'Nissan' => 'Nissan',
                        'Renault' => 'Renault',
                        'Peugeot' => 'Peugeot',
                        'Citroën' => 'Citroën',
                        'BMW' => 'BMW',
                        'Mercedes-Benz' => 'Mercedes-Benz',
                        'Audi' => 'Audi',
                        'Hyundai' => 'Hyundai',
                        'Kia' => 'Kia',
                        'Mazda' => 'Mazda',
                        'Subaru' => 'Subaru',
                        'Suzuki' => 'Suzuki',
                        'Dodge' => 'Dodge',
                        'Jeep' => 'Jeep',
                        'Chrysler' => 'Chrysler',
                        'Ram' => 'Ram',
                        'GMC' => 'GMC',
                        'Cadillac' => 'Cadillac',
                        'Tesla' => 'Tesla',
                        'Volvo' => 'Volvo',
                        'Jaguar' => 'Jaguar',
                        'Land Rover' => 'Land Rover',
                        'Mini' => 'Mini',
                        'Mitsubishi' => 'Mitsubishi',
                        'Lexus' => 'Lexus',
                        'Infiniti' => 'Infiniti',
                        'Acura' => 'Acura',
                        'Lincoln' => 'Lincoln',
                        'Buick' => 'Buick',
                        'Alfa Romeo' => 'Alfa Romeo',
                        'Otro' => 'Otro',
                    ],
                    'placeholder' => 'Seleccione la marca',
                    'label' => 'Marca del vehículo',
            ])
            ->add('modelo')
            ->add('anio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehiculo::class,
        ]);
    }
}
