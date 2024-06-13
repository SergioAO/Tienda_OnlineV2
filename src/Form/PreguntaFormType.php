<?php

// src/Form/PreguntaType.php

namespace App\Form;

use App\Entity\Pregunta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreguntaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texto', TextareaType::class, [
                'label' => 'Tu comentario',
                'attr' => ['rows' => 5],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pregunta::class,
        ]);
    }
}
