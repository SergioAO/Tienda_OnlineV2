<?php

// src/Form/DatoPagoFormType.php

namespace App\Form;

use App\Entity\DatoDePago;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatoPagoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroTarjeta', TextType::class, [
                'label' => 'Número de Tarjeta',
            ])
            ->add('titularNombre', TextType::class, [
                'label' => 'Nombre del Titular',
            ])
            ->add('codigoDeSeguridad', TextType::class, [
                'label' => 'Código de Seguridad',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DatoDePago::class,
        ]);
    }
}
