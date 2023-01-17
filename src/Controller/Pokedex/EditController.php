<?php

namespace App\Controller\Pokedex;

use App\Entity\UserPokedex;
use App\Form\UserPokedexUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pokedex/{id}/edit', name: 'app_pokedex_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request, UserPokedex $pokedex): Response
    {
        if ($this->getUser() !== $pokedex->getTrainer()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(UserPokedexUpdateType::class, $pokedex)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserPokedex $pokedex */
            $pokedex = $form->getData();

            $pokedex
                ->setUpdatedAt(new \DateTimeImmutable())
            ;

            $this->entityManager->persist($pokedex);
            $this->entityManager->flush();

            $this->addFlash("success", "Votre pokédex {$pokedex->getName()} a bien été modifié !");

            return $this->redirectToRoute('app_pokedex_view', ['id' => $pokedex->getId()]);
        }

        return $this->render('pokedex/edit.html.twig', [
            'form' => $form->createView(),
            'pokedex' => $pokedex,
        ]);
    }
}
