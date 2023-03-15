<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserPokedex;
use App\Repository\UserPokedexRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/{nickname}', name: 'app_profile')]
class ProfileController extends AbstractController
{
    public function __construct(
        private readonly UserPokedexRepository $userPokedexRepository,
    ) {}

    public function __invoke(User $user): Response
    {
        $pokedex = $this->userPokedexRepository->findWithUser($this->getUser());

        return $this->render('profile.html.twig', [
            'user' => $user,
            'user_pokedex' => $pokedex,
            'completion' => $this->calculateCompletion($pokedex),
        ]);

    }

    /**
     * @param UserPokedex[] $pokedex
     *
     * @return int
     */
    private function calculateCompletion(array $pokedex): int
    {
        $totalCaught = 0;
        $totalPokemon = 0;

        foreach ($pokedex as $dex) {
            $totalCaught += $dex->getPokemonCaught();
            $totalPokemon += $dex->getPokemon()->count();
        }

        if (0 === $totalPokemon) {
            return 0;
        }

        return ceil($totalCaught * 100 / $totalPokemon);
    }
}
