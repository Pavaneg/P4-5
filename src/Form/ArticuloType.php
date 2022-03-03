<?php

namespace App\Form;

use App\Entity\Articulo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('fecha')
            ->add('texto')
            ->add('categoria', ChoiceType::class,[
                'choices' => [
                    'Opinión' => 'Opinión',
                    'Reportaje' => 'Reportaje',
                    'Entrevista' => 'Entrevista',
                    'Divulgación' => 'Divulgación',
                    'Editorial' => 'Editorial',
                    'Crítica' => 'Crítica',
                    'Informativo' => 'Informativo',
                    'Columna' => 'Columna',
                    'Otros' => 'Otros'
                ]
            ])
            ->add('resumen')
            ->add('comentario')
            ->add('url')
            ->add('medio', ChoiceType::class,[
                'choices' => [
                    'Papel' => 'Papel',
                    'Digital' => 'Digital',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articulo::class,
        ]);
    }
}
