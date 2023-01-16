<?php

namespace App\Controller\Admin\Pokedex\Pokemon;

use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Entity\Pokemon;
use App\Form\PokedexPokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/pokemon/{id}', name: 'app_admin_pokedex_pokemon_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(PokedexPokemon $pokemon, Request $request): Response
    {
        $form = $this->createForm(PokedexPokemonType::class, $pokemon)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PokedexPokemon $pokemon */
            $pokemon = $form->getData();
            $pokemon->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokedex_edit', ['id' => $pokemon->getPokedex()->getId()]);
        }

        return $this->render('admin/pokedex/pokemon/edit.html.twig', [
            'form' => $form->createView(),
            'pokemon' => $pokemon,
        ]);
    }
}
