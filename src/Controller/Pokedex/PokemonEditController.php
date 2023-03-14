<?php

namespace App\Controller\Pokedex;

use App\Entity\TrainerPokedexPokemon;
use App\Entity\UserPokedexPokemon;
use App\Form\TrainerPokedexPokemonType;
use App\Form\UserPokedexPokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pokedex/pokemon/edit/{id}', name: 'app_pokedex_pokemon_edit')]
class PokemonEditController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function __invoke(Request $request, UserPokedexPokemon $pokemon): Response
    {
        if ($this->getUser() !== $pokemon->getPokedex()->getTrainer()) {
            return $this->redirectToRoute('app_home');
        }
        
        $form = $this->createForm(UserPokedexPokemonType::class, $pokemon, [
            'game' => $pokemon->getPokedex()->getBaseGame(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserPokedexPokemon $pokemon */
            $pokemon = $form->getData();
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute(
                'app_pokedex_view',
                ['id' => $pokemon->getPokedex()->getId()]
            );
        }

        return $this->render('pokedex/pokemon_edit.html.twig', [
            'form' => $form->createView(),
            'pokedexId' => $pokemon->getPokedex()->getId(),
        ]);
    }
}
