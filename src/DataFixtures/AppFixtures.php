<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Entity\Pokemon;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $time = new \DateTimeImmutable();
        $trainer = (new User())
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setEmail('lepelley@live.fr')
            ->setNickname('Vincent')
            ->setCreatedAt($time)
            ->setUpdatedAt($time);
        $trainer->setPassword($this->passwordHasher->hashPassword($trainer, 'test'));
        $manager->persist($trainer);

        $poke = [];
        $fileHandle = fopen("var/pokemon.csv", "r");
        while (($row = fgetcsv($fileHandle, 0, ",")) !== false) {
            $pokemon = (new Pokemon())
                ->setName($row[1])
                ->setNationalNumber($row[0])
                ->setIsOnline(true)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $manager->persist($pokemon);
            $poke[] = $pokemon;
        }

        $game = (new Game())
            ->setName('Violet')
            ->setIsOnline(true)
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
        ;
        $manager->persist($game);

        $game = (new Game())
            ->setName('Écarlate')
            ->setIsOnline(true)
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
        ;
        $manager->persist($game);

        $game = (new Game())
            ->setName('HOME')
            ->setIsOnline(true)
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
        ;
        $manager->persist($game);

        $pokedex = (new Pokedex())
            ->setName('Paldea')
            ->setIsOnline(true)
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
            ->setIsRegional(true)
            ->setIsShinyUnavailable(false)
        ;
        $manager->persist($pokedex);

        $pokedex = (new Pokedex())
            ->setName('HOME')
            ->setIsOnline(true)
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
            ->setIsRegional(false)
            ->setIsShinyUnavailable(false)
        ;
        $manager->persist($pokedex);

        foreach ($poke as $p) {
            $dexMon = (new PokedexPokemon())
                ->setPokemon($p)
                ->setPokedex($pokedex)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
                ->setIsShinyUnavailable(false)
            ;
            $manager->persist($dexMon);
        }
        $manager->persist($pokedex);

        $manager->flush();
    }
}
