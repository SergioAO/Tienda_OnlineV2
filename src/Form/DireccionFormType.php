<?php

// src/Form/DireccionFormType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DireccionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo_via', ChoiceType::class, [
                'choices' => [
                    'Calle' => 'Calle',
                    'Avenida' => 'Avenida',
                    'Calleja' => 'Calleja',
                    'Vía' => 'Vía'
                ],
                'label' => 'Tipo de vía',
                'placeholder' => 'Selecciona el tipo de vía',
                'attr' => ['class' => 'form-control']
            ])
            ->add('direccion', TextType::class, [
                'label' => 'Dirección',
                'attr' => ['class' => 'form-control']
            ])
            ->add('comunidad', ChoiceType::class, [
                'choices' => $this->getComunidades(),
                'label' => 'Comunidad Autónoma',
                'placeholder' => 'Selecciona una comunidad',
                'attr' => ['class' => 'form-control comunidad-select', 'id' => 'comunidad-select']
            ])
            ->add('provincia', ChoiceType::class, [
                'choices' => [],
                'label' => 'Provincia',
                'placeholder' => 'Selecciona una provincia',
                'attr' => ['class' => 'form-control', 'id' => 'provincia-select']
            ])
            ->add('codigo_postal', TextType::class, [
                'label' => 'Código Postal',
                'attr' => ['class' => 'form-control']
            ])
            ->add('guardar', SubmitType::class, [
                'label' => 'Guardar Dirección',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    private function getComunidades(): array
    {
        return [
            'Andalucía' => 'Andalucía',
            'Aragón' => 'Aragón',
            'Asturias' => 'Asturias',
            'Islas Baleares' => 'Islas Baleares',
            'Canarias' => 'Canarias',
            'Cantabria' => 'Cantabria',
            'Castilla-La Mancha' => 'Castilla-La Mancha',
            'Castilla y León' => 'Castilla y León',
            'Cataluña' => 'Cataluña',
            'Extremadura' => 'Extremadura',
            'Galicia' => 'Galicia',
            'Madrid' => 'Madrid',
            'Murcia' => 'Murcia',
            'Navarra' => 'Navarra',
            'País Vasco' => 'País Vasco',
            'La Rioja' => 'La Rioja',
            'Comunidad Valenciana' => 'Comunidad Valenciana',
            'Ceuta' => 'Ceuta',
            'Melilla' => 'Melilla'
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
