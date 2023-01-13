<?php

namespace App\Form;

use App\Entity\Ball;
use App\Entity\Game;
use App\Entity\UserPokedexPokemon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPokedexPokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isCaptured', CheckboxType::class, [
                'label' => 'Attrapé ?',
                'required' => false,
            ])
            ->add('captureGame', EntityType::class, [
                'label' => 'Capturé sur',
                'class' => Game::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('captureBall', EntityType::class, [
                'label' => 'Ball',
                'class' => Ball::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('notes', TextType::class, [
                'label' => 'Notes',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPokedexPokemon::class,
        ]);
    }
}
