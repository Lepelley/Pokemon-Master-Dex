<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\UserPokedex;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPokedexType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('game', EntityType::class, [
                'label' => 'Jeu(x)/Génération',
                'class' => Game::class,
                'choice_label' => 'name',
            ])
            ->add('isShiny', CheckboxType::class, [
                'label' => 'Version chromatique',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPokedex::class,
        ]);
    }
}
