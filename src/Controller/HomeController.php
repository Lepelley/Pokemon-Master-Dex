<?php

namespace App\Controller;

use App\Repository\UserPokedexRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly UserPokedexRepository $repository) {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'user_pokedex' => $this->repository->findAll(),
        ]);
    }
}
