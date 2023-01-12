<?php

namespace App\Controller\Admin\Game;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/game/list', name: 'app_admin_game_list')]
class ListController extends AbstractController
{
    public function __invoke(GameRepository $repository): Response
    {
        return $this->render('admin/game/list.html.twig', [
            'games' => $repository->findAll(),
        ]);
    }
}
