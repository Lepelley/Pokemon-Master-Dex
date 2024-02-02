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
            ['National 1G', 152],
            ['National 1G Master Dex', 152],
            ['National 2G', 252],
            ['National 2G Master Dex', 252],
            ['National 3G', 387],
            ['National 3G Master Dex', 387],
            ['National 4G', 494],
            ['National 4G Master Dex', 494],
            ['National 5G', 650],
            ['National 5G Master Dex', 650],
            ['National 6G', 722],
            ['National 6G Master Dex', 722],
            ['National 7G', 808],
            ['National 7G Master Dex', 808],
            ['National 8G', 906],
            ['National 9G', 1026],
            ['HOME Master Dex', 1026],
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
