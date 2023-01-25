<?php

namespace App\Controller\Admin\Pokedex\Pokemon;

use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Entity\UserPokedexPokemon;
use App\Form\PokedexPokemonType;
use App\Repository\UserPokedexRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/{id}/pokemon/create', name: 'app_admin_pokedex_pokemon_create')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPokedexRepository $userPokedexRepository,
    ) {}

    public function __invoke(Pokedex $pokedex, Request $request): Response
    {
        $pokemon = new PokedexPokemon();
        $form = $this->createForm(PokedexPokemonType::class, $pokemon)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PokedexPokemon $pokemon */
            $pokemon = $form->getData();
            $time = new \DateTimeImmutable();
            $pokemon
                ->setPokedex($pokedex)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->addNewPokemonToUserDex($pokemon);
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokedex_edit', ['id' => $pokemon->getPokedex()->getId()]);
        }

        return $this->render('admin/pokedex/pokemon/create.html.twig', [
            'form' => $form->createView(),
            'pokedex' => $pokedex,
        ]);
    }

    private function addNewPokemonToUserDex(PokedexPokemon $pokedexPokemon): void
    {
        $time = new \DateTimeImmutable();
        foreach ($this->userPokedexRepository->findBy(['pokedex_id' => $pokedexPokemon->getPokedex()]) as $pokedex) {
            $pokemon = (new UserPokedexPokemon())
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
                ->setPokemon($pokedexPokemon)
                ->setPokedex($pokedex)
                ->setIsCaptured(false)
            ;
            $this->entityManager->persist($pokemon);
            $this->entityManager->persist($pokedex);
        }
    }
}
