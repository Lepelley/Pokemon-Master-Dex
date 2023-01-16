<?php

namespace App\Controller\Admin\Game;

use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/game/{id}/edit', name: 'app_admin_game_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Game $game */
            $game = $form->getData();
            $game->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_game_list');
        }

        return $this->render('admin/game/edit.html.twig', [
            'form' => $form->createView(),
            'game' => $game,
        ]);
    }
}
