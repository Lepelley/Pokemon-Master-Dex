<?php

namespace App\Form;

use App\Entity\Pokemon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('nationalNumber', IntegerType::class, [
                'label' => 'Numéro du Pokédex National (optionnelle)',
                'required' => false,
                'attr' => ['min' => '1'],
            ])
            ->add('isOnline', CheckboxType::class, [
                'label' => 'En ligne',
                'required' => false,
            ])
            ->add('image', TextType::class, [
                'label' => 'Image / Classe CSS pour le sprite',
                'required' => false,
            ])
            ->add('imageShiny', TextType::class, [
                'label' => 'Image / Classe CSS pour le sprite shiny',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
