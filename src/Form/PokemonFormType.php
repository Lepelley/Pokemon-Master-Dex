<?php

namespace App\Form;

use App\Entity\Pokemon;
use App\Entity\PokemonForm;
use App\Repository\PokemonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pokemon', EntityType::class, [
                'label' => 'Pokémon',
                'class' => Pokemon::class,
                'choice_label' => 'name',
                'query_builder' => function (PokemonRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.isOnline = :val')
                        ->setParameter('val', true)
                        ;
                },
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('isGenderDifference', CheckboxType::class, [
                'label' => 'Forme mâle/femelle',
                'required' => false,
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
            'data_class' => PokemonForm::class,
        ]);
    }
}
