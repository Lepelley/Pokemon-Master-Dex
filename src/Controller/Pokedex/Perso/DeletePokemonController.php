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

#[Route('/pokedex/{id}/perso/{pokemon}/delete', name: 'app_pokedex_perso_pokemon_delete')]
#[IsGranted("ROLE_USER")]
class DeletePokemonController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UserPokedex $pokedex, UserPokedexPokemon $pokemon, Request $request): Response
    {
        if ($this->getUser() !== $pokedex->getTrainer()) {
            return $this->redirectToRoute('app_home');
        }

        $token = $request->request->get('token');

        if (!$this->isCsrfTokenValid('delete', $token)) {
            return $this->redirectToRoute('app_pokedex_pokemon_edit', ['id' => $pokemon->getId()]);
        }

        $pokedex->removePokemon($pokemon);
        $this->entityManager->remove($pokemon);
        $this->entityManager->persist($pokedex);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            "Le pokémon {$pokemon->getPokemon()->getPokemon()->getName()} a été supprimé de {$pokedex->getName()} avec succès !"
        );

        return $this->redirectToRoute('app_pokedex_view', ['id' => $pokedex->getId()]);
    }

}
