<?php

namespace App\Controller\Admin\Pokedex;

use App\Entity\Pokedex;
use App\Repository\PokedexRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/{id}/copy', name: 'app_admin_pokedex_copy')]
class CopyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){}

    public function __invoke(Pokedex $pokedex): Response
    {
        $time = new \DateTimeImmutable();

        $pokedexCopy = (new Pokedex())
            ->setIsRegional($pokedex->isRegional())
            ->setIsShinyUnavailable($pokedex->isShinyUnavailable())
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
            ->setName($pokedex->getName())
            ->setIsOnline($pokedex->isOnline())
        ;

        foreach ($pokedex->getGames() as $game) {
            $pokedexCopy->addGame($game);
        }

        foreach ($pokedex->getPokemon() as $pokemon) {
            $pokedexCopy->addPokemon($pokemon);
        }

        $this->entityManager->persist($pokedexCopy);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_pokedex_edit', ['id' => $pokedexCopy->getId()]);
    }
}
