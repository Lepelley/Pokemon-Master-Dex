<?php

namespace App\Controller\Admin\Ball;

use App\Repository\BallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/admin/ball/', name: 'app_admin_ball_list')]
    public function index(BallRepository $repository): Response
    {
        return $this->render('admin/ball/list.html.twig', [
            'balls' => $repository->findAll(),
        ]);
    }
}
