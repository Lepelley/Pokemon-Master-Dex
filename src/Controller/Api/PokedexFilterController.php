<?php

namespace App\Controller\Api;

use App\Repository\PokedexRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/pokedex/filter', name: 'app_api_pokedex_filter', methods: ['POST'])]
class PokedexFilterController extends AbstractController
{
    public function __construct(
        private readonly PokedexRepository $pokedexRepository
    ){}

    public function __invoke(Request $request): Response
    {
        return $this->json($this->pokedexRepository->findWithGameId((int) $request->get('id')));
    }
}
