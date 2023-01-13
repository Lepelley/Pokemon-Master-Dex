<?php

namespace App\Controller\Admin\Pokemon;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokemon', name: 'app_admin_pokemon_list')]
class ListController extends AbstractController
{
    public function __invoke(PokemonRepository $repository): Response
    {
        return $this->render('admin/pokemon/list.html.twig', [
            'pokemon' => $repository->findAll(),
        ]);
    }
}
