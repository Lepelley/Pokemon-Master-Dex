<?php

namespace App\Controller\Pokedex;

use App\Entity\UserPokedex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pokedex/view/{id}', name: 'app_pokedex_view')]
class ViewController extends AbstractController
{
    public function __invoke(UserPokedex $pokedex): Response
    {
        return $this->render('pokedex/view.html.twig', [
            'pokedex' => $pokedex,
        ]);
    }
}
