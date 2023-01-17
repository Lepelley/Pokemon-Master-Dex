<?php

namespace App\Controller\Admin\Pokedex\Pokemon;

use App\Entity\PokedexPokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/pokemon/{id}/delete', name: 'app_admin_pokedex_pokemon_delete')]
class DeleteController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){}

    public function __invoke(Request $request, PokedexPokemon $pokemon): Response
    {
        /** @var string|null $token */
        $token = $request->request->get('token');

        if (!$this->isCsrfTokenValid('delete', $token)) {
            return $this->redirectToRoute('app_admin_pokedex_edit', ['id' => $pokemon->getPokedex()->getId()]);
        }

        $this->entityManager->remove($pokemon);
        $pokedex = $pokemon->getPokedex();
        $pokedex->removePokemon($pokemon);
        $this->entityManager->persist($pokedex);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            "Le pokémon {$pokemon->getPokemon()->getName()} a été supprimé de {$pokedex->getName()} avec succès !"
        );

        return $this->redirectToRoute('app_admin_pokedex_edit', ['id' => $pokemon->getPokedex()->getId()]);
    }
}
