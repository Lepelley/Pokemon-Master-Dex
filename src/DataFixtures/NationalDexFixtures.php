<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Repository\PokedexRepository;
use App\Repository\PokemonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalDexFixtures extends Fixture
{
    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
        private readonly PokedexRepository $pokedexRepository,
    ) {}

    public function load(ObjectManager $manager)
    {
        $data = [
            ['National 1G', 151],
            ['National 2G', 251],
            ['National 3G', 386],
            ['National 4G', 494],
            ['National 5G', 649],
            ['National 6G', 721],
            ['National 7G', 808],
        ];

        $time = new \DateTimeImmutable();
        foreach ($data as $row) {
            $pokedex = $this->pokedexRepository->findOneBy(['name' => $row[0]]);

            $poke = $this->pokemonRepository->findNationalBefore($row[1]);
            foreach ($poke as $p) {
                $pokemon = (new PokedexPokemon())
                    ->setPokemon($p)
                    ->setIsShinyUnavailable(false)
                    ->setCreatedAt($time)
                    ->setUpdatedAt($time)
                    ->setPokedex($pokedex)
                ;
                $manager->persist($pokemon);
            }
            $manager->flush();
        }
    }
}
