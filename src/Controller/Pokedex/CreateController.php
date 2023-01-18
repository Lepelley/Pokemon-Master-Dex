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
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pokedex/create', name: 'app_pokedex_create')]
#[IsGranted("ROLE_USER")]
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

            if ($pokedex->getPokedex()->isShinyUnavailable() && $pokedex->isShiny()) {
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
            $entry = (new UserPokedexPokemon())
                ->setPokedex($pokedex)
                ->setPokemon($pokemon)
                ->setIsCaptured(false)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($entry);
        }

        return;
    }
}
