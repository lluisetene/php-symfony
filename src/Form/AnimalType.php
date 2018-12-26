<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AnimalType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST') // Si no se indica se pone POST por defecto
                //->setAction($this->generateUrl('animal_save')) // Redirige a esa URL

                ->add('tipo', TextType::class, [
                'label' => 'Tipo animal'
                    ])
                ->add('color', TextType::class)
                ->add('raza', TextType::class)
                ->add('submit', SubmitType::class, [
                    'label' => 'Crear Animal',
                    'attr' => [ 'class' => 'btn btn-success' ]
                ]);

    }
}