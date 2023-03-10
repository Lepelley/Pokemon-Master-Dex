<?php

namespace App\Form;

use App\Entity\Pokedex;
use App\Entity\PokemonForm;
use App\Repository\PokemonFormRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokedexFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pokemonForms', EntityType::class, [
                'label' => 'Pokémon',
                'class' => PokemonForm::class,
                'choice_label' => fn (PokemonForm $form) =>
                    $form->isIsGenderDifference()
                        ? $form->getPokemon()->getName() . ' mâle/femelle'
                        : $form->getName()
                ,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (PokemonFormRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.isOnline = :val')
                        ->setParameter('val', true)
                        ;
                },
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
