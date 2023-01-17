<?php

namespace App\DataFixtures;

use App\Entity\PokedexPokemon;
use App\Repository\PokedexRepository;
use App\Repository\PokemonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaldeaFixtures extends Fixture
{
    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
        private readonly PokedexRepository $pokedexRepository,
    ) {}

    public function load(ObjectManager $manager)
    {
        $time = new \DateTimeImmutable();
        $fileHandle = fopen("var/paldea.csv", "r");
        while (($row = fgetcsv($fileHandle, 0, ",")) !== false) {
            $pokemon = (new PokedexPokemon())
                ->setRegionalNumber((int) substr($row[0], 1))
                ->setPokemon($this->pokemonRepository->findOneBy(['name' => $row[2]]))
                ->setIsShinyUnavailable(false)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
                ->setPokedex($this->pokedexRepository->findOneBy(['name' => 'Paldea']))
            ;
            if ($this->pokemonRepository->findOneBy(['name' => $row[2]]) === null) {
                dump($row[2]);
            }
            $manager->persist($pokemon);
            $manager->flush();
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];
    }
}
