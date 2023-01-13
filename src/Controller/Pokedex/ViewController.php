<?php

namespace App\Controller\Pokedex;

use App\Entity\UserPokedex;
use App\Repository\UserPokedexPokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pokedex/view/{id}', name: 'app_pokedex_view')]
class ViewController extends AbstractController
{
    public function __construct(
        private readonly UserPokedexPokemonRepository $userPokedexPokemonRepository,
    ) {}

    public function __invoke(UserPokedex $pokedex): Response
    {
        $caught = $this->userPokedexPokemonRepository->pokemonCaughtByEntity($pokedex);
        $pokedex
            ->setPokemonCaught($caught)
            ->setPokemonCaughtPerCent($caught)
        ;

        return $this->render('pokedex/view.html.twig', [
            'pokedex' => $pokedex,
        ]);
    }

    private function calculPerCent($caught, $total) : int
    {
        return ceil($caught * 100 / $total);
    }
}
