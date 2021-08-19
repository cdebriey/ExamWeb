<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Marque')
            ->add('Modele')
            ->add('PrixDemande')
            ->add('Image')
            ->add('Kilometrage')
            ->add('Cylindree')
            ->add('Puissance')
            ->add('Description')
            ->add('AnneeDeMiseEnCirculation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
