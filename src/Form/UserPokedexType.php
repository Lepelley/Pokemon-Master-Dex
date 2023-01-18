<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\UserPokedex;
use App\Repository\GameRepository;
use App\Repository\PokedexRepository;
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
            ->add('baseGame', EntityType::class, [
                'label' => 'Jeu de base',
                'class' => Game::class,
                'choice_label' => 'name',
                'required' => false,
                'query_builder' => function (GameRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.isOnline = :val')
                        ->setParameter('val', true)
                        ;
                },
            ])
            ->add('pokedex', EntityType::class, [
                'label' => 'Pokédex',
                'class' => Pokedex::class,
                'choice_label' => 'name',
                'query_builder' => function (PokedexRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.isOnline = :val')
                        ->setParameter('val', true)
                    ;
                },
            ])
            ->add('isShiny', CheckboxType::class, [
                'label' => 'Version chromatique',
                'required' => false,
            ])
            ->add('preventSpoil', CheckboxType::class, [
                'label' => 'Cacher les noms et images des Pokémon non attrapés.',
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
