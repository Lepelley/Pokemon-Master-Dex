<?php

namespace App\Controller\Pokedex;

use App\Entity\UserPokedex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pokedex/view/{id}/bg', name: 'app_pokedex_bg_view')]
class BgViewController extends AbstractController
{
    public function __invoke(UserPokedex $pokedex, Request $request): Response
    {
        return $this->render('pokedex/bg_view.html.twig', [
            'pokedex' => $pokedex,
            'width' => $request->get('width') ?? 0,
            'height' => $request->get('height') ?? 0,
            'loopFor' => $request->get('loop_for') ?? 1,
        ]);
    }
}
