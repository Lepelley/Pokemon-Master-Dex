<?php

namespace App\Controller\Admin\Pokedex;

use App\Repository\PokedexRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/list', name: 'app_admin_pokedex_list')]
class ListController extends AbstractController
{
    public function __invoke(PokedexRepository $pokedexRepository): Response
    {
        return $this->render('admin/pokedex/list.html.twig', [
            'pokedex' => $pokedexRepository->findAll(),
        ]);
    }
}
