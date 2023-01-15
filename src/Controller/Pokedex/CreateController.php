<?php

namespace App\Controller\Pokedex;

use App\Entity\UserPokedex;
use App\Entity\UserPokedexPokemon;
use App\Form\UserPokedexType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pokedex/create', name: 'app_pokedex_create')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $pokedex = new UserPokedex();
        $form = $this->createForm(UserPokedexType::class, $pokedex);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserPokedex $pokedex */
            $pokedex = $form->getData();

            if ($pokedex->getPokedex()->isIsShinyUnavailable() && $pokedex->isShiny()) {
                $this->addFlash('danger', "Ce Pokédex n'est pas disponible en shiny.");
            } else {
                $time = new \DateTimeImmutable();
                $pokedex
                    ->setTrainer($this->getUser())
                    ->setCreatedAt($time)
                    ->setUpdatedAt($time)
                ;
                $this->createEntriesForPokedex($pokedex, $time);
                $this->entityManager->persist($pokedex);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_pokedex_view', ['id' => $pokedex->getId()]);
            }
        }

        return $this->render('pokedex/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createEntriesForPokedex(UserPokedex $pokedex, \DateTimeImmutable $time): void
    {
        foreach ($pokedex->getPokedex()->getPokemon() as $pokemon) {
            if (!($pokedex->isShiny() && $pokemon->isIsShinyUnavailable())) {
                $entry = (new UserPokedexPokemon())
                    ->setPokedex($pokedex)
                    ->setPokemon($pokemon)
                    ->setIsCaptured(false)
                    ->setCreatedAt($time)
                    ->setUpdatedAt($time)
                ;
                $this->entityManager->persist($entry);
            }
        }

        return;
    }
}
