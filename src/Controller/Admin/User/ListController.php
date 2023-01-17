<?php

namespace App\Controller\Admin\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user/list', name: 'app_admin_user_list')]
class ListController extends AbstractController
{
    public function __invoke(UserRepository $repository): Response
    {
        return $this->render('admin/user/list.html.twig', [
            'users' => $repository->findAll(),
        ]);
    }
}
