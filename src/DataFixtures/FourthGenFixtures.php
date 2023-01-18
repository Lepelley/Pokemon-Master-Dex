<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Repository\PokedexRepository;
use App\Repository\PokemonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FourthGenFixtures extends Fixture
{
    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
        private readonly PokedexRepository $pokedexRepository,
    ) {}

    public function load(ObjectManager $manager)
    {
        $time = new \DateTimeImmutable();
        $pokedex = $this->pokedexRepository->findOneBy(['name' => 'National 4G']);

        $poke = $this->pokemonRepository->findNationalBefore(494);
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
