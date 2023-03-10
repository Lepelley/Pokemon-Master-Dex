<?php

namespace App\Controller\Admin\PokemonForm;

use App\Repository\PokemonFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokemon/form', name: 'app_admin_pokemon_form_list')]
class ListController extends AbstractController
{
    public function __invoke(PokemonFormRepository $repository): Response
    {
        return $this->render('admin/pokemon_form/list.html.twig', [
            'pokemon' => $repository->findAll(),
        ]);
    }
}
