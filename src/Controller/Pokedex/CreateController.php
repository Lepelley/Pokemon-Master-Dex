<?php

namespace App\Controller\Pokedex;

use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Entity\PokemonForm;
use App\Entity\UserPokedex;
use App\Entity\UserPokedexPokemon;
use App\Form\UserPokedexType;
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

            $time = new \DateTimeImmutable();
            $pokedex
                ->setTrainer($this->getUser())
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->createEntriesForPokedex($pokedex, $pokedex->getPokedex());
            $this->entityManager->persist($pokedex);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_pokedex_view', ['id' => $pokedex->getId()]);
        }

        return $this->render('pokedex/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createEntriesForPokedex(UserPokedex $userPokedex, Pokedex $pokedex): void
    {
        foreach ($pokedex->getPokemon() as $pokemon) {
            $entry = $this->createUserPokedexPokemon($userPokedex, $pokemon);
            $this->entityManager->persist($entry);
        }

        foreach ($pokedex->getPokemonForms() as $form) {
            if ($form->isIsGenderDifference()) {
                $entry = $this->createUserPokedexPokemon($userPokedex, null, $form, true);
                $this->entityManager->persist($entry);

                $entry2 = $this->createUserPokedexPokemon($userPokedex, null, $form, false);
                $this->entityManager->persist($entry2);
            } else {
                $entry = $this->createUserPokedexPokemon($userPokedex, null, $form);
                $this->entityManager->persist($entry);
            }
        }

        return;
    }

    private function createUserPokedexPokemon(UserPokedex $pokedex, ?PokedexPokemon $pokemon, ?PokemonForm $form = null, bool $isMale = false) : UserPokedexPokemon
    {
        return (new UserPokedexPokemon())
            ->setPokedex($pokedex)
            ->setPokemon($pokemon)
            ->setForm($form)
            ->setIsMale($isMale)
            ->setIsCaptured(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
        ;
    }
}
