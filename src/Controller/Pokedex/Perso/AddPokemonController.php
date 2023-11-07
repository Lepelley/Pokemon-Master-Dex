<?php

namespace App\Controller\Pokedex\Perso;

use App\Entity\PokedexPokemon;
use App\Entity\PokemonForm;
use App\Entity\UserPokedex;
use App\Entity\UserPokedexPokemon;
use App\Form\UserPokedexPersoAddPokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pokedex/{id}/perso/add', name: 'app_pokedex_perso_pokemon_add')]
#[IsGranted("ROLE_USER")]
class AddPokemonController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UserPokedex $pokedex, Request $request): Response
    {
        $pokemon = new PokedexPokemon();
        $form = $this->createForm(UserPokedexPersoAddPokemonType::class, $pokemon);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $time = new \DateTimeImmutable();
            $userPokedexPokemon = (new UserPokedexPokemon())
                ->setPokedex($pokedex)
                ->setPokemon($pokemon)
                ->setCaptureGame($pokedex->getBaseGame())
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
                ->setIsCaptured(false)
                ->setIsMale(false)
            ;

            $pokemon
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;

            $this->entityManager->persist($userPokedexPokemon);
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_pokedex_view', ['id' => $pokedex->getId()]);
        }

        return $this->render('pokedex/pokemon_add.html.twig', [
            'form' => $form->createView(),
            'pokedex' => $pokedex,
        ]);
    }
}
