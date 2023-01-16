<?php

namespace App\Form;

use App\Entity\PokedexPokemon;
use App\Entity\Pokemon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokedexPokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pokemon', EntityType::class, [
                'label' => 'Pokémon',
                'class' => Pokemon::class,
                'choice_label' => 'name',
            ])
            ->add('regionalNumber', IntegerType::class, [
                'label' => 'Numéro du Pokédex régional (optionnelle)',
                'required' => false,
                'attr' => ['min' => '1'],
            ])
            ->add('isShinyUnavailable', CheckboxType::class, [
                'label' => 'Shiny non disponible',
                'required' => false,
            ])
            ->add('specificName', TextType::class, [
                'label' => 'Nom spécifique à ce Pokédex',
                'required' => false,
            ])
            ->add('specificImage', TextType::class, [
                'label' => 'Image spécifique à ce Pokédex',
                'required' => false,
            ])
            ->add('specificShinyImage', TextType::class, [
                'label' => 'Image chromatique spécifique à ce Pokédex',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PokedexPokemon::class,
        ]);
    }
}
