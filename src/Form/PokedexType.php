<?php

namespace App\Form;

use App\Entity\Pokedex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokedexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('isRegional', CheckboxType::class, [
                'label' => 'Régional',
                'required' => false,
            ])
            ->add('isOnline', CheckboxType::class, [
                'label' => 'En ligne',
                'required' => false,
            ])
            ->add('isShinyUnavailable', CheckboxType::class, [
                'label' => 'Non Disponible en shiny',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokedex::class,
        ]);
    }
}
