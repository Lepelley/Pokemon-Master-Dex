<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Repository\PokedexRepository;
use App\Repository\PokemonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LGPEFixtures extends Fixture
{
    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
        private readonly PokedexRepository $pokedexRepository,
    ) {}

    public function load(ObjectManager $manager)
    {
        $time = new \DateTimeImmutable();
        $pokedex = $this->pokedexRepository->findOneBy(['name' => "Kanto de Let's Go Pikachu & Let's Go Évoli"]);

        $fileHandle = fopen("var/lgpe.csv", "r");
        while (($row = fgetcsv($fileHandle, 0, ",")) !== false) {
            $pokemon = (new PokedexPokemon())
                ->setRegionalNumber((int) substr($row[0], 1))
                ->setPokemon($this->pokemonRepository->findOneBy(['name' => $row[2]]))
                ->setIsShinyUnavailable(false)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
                ->setPokedex($pokedex)
            ;
            if ($this->pokemonRepository->findOneBy(['name' => $row[2]]) === null) {
                dump($row[2]);
            }
            $manager->persist($pokemon);
        }
        $manager->flush();
    }
}
