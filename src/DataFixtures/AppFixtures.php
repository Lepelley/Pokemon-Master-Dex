<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Entity\Pokemon;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\PokedexRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly PokedexRepository $pokedexRepository,
        private readonly GameRepository $gameRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $time = new \DateTimeImmutable();

        $games = [
            'Vert' => new \DateTimeImmutable('1996-02-27'),
            'Rouge' => new \DateTimeImmutable('1996-02-27'),
            'Bleu' => new \DateTimeImmutable('1996-10-15'),
            'Jaune' => new \DateTimeImmutable('1998-09-12'),
            'Or' => new \DateTimeImmutable('1999-11-21'),
            'Argent' => new \DateTimeImmutable('1999-11-21'),
            'Cristal' => new \DateTimeImmutable('2000-12-14'),
            'Rubis' => new \DateTimeImmutable('2002-11-21'),
            'Saphir' => new \DateTimeImmutable('2002-11-21'),
            'Colosseum' => new \DateTimeImmutable('2003-03-21'),
            'Rouge Feu' => new \DateTimeImmutable('2004-01-29'),
            'Vert Feuille' => new \DateTimeImmutable('2004-01-29'),
            'Émeraude' => new \DateTimeImmutable('2004-09-16'),
            'XD : Le Souffle des Ténèbres' => new \DateTimeImmutable('2005-08-04'),
            'Diamant' => new \DateTimeImmutable('2006-09-28'),
            'Perle' => new \DateTimeImmutable('2006-09-28'),
            'Platine' => new \DateTimeImmutable('2008-09-13'),
            'HeartGold' => new \DateTimeImmutable('2009-09-12'),
            'SoulSilver' => new \DateTimeImmutable('2009-09-12'),
            'Noir' => new \DateTimeImmutable('2010-09-18'),
            'Blanc' => new \DateTimeImmutable('2010-09-18'),
            'Noir 2' => new \DateTimeImmutable('2012-06-23'),
            'Blanc 2' => new \DateTimeImmutable('2012-06-23'),
            'X' => new \DateTimeImmutable('2013-10-12'),
            'Y' => new \DateTimeImmutable('2013-10-12'),
            'Rubis Oméga' => new \DateTimeImmutable('2014-11-21'),
            'Saphir Alpha' => new \DateTimeImmutable('2014-11-21'),
            'Soleil' => new \DateTimeImmutable('2016-11-18'),
            'Lune' => new \DateTimeImmutable('2016-11-18'),
            'Ultra-Soleil' => new \DateTimeImmutable('2017-11-17'),
            'Ultra-Lune' => new \DateTimeImmutable('2017-11-17'),
            "Let's Go Pikachu" => new \DateTimeImmutable('2018-11-16'),
            "Let's Go Évoli" => new \DateTimeImmutable('2018-11-16'),
            "Épée" => new \DateTimeImmutable('2019-11-15'),
            "Bouclier" => new \DateTimeImmutable('2019-11-15'),
            "HOME" => new \DateTimeImmutable("2020-02-12"),
            "Diamant Étincelant" => new \DateTimeImmutable('2021-11-19'),
            "Perle Scintillante" => new \DateTimeImmutable('2021-11-19'),
            "Légendes : Arceus" => new \DateTimeImmutable('2022-01-28'),
            "Écarlate" => new \DateTimeImmutable('2022-11-18'),
            "Violet" => new \DateTimeImmutable('2022-11-18'),
        ];

        foreach ($games as $name => $date) {
            $game = (new Game())
                ->setName($name)
                ->setReleaseDate($date)
                ->setIsOnline(true)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $manager->persist($game);
        }
        $manager->flush();

        $array = [
            ['National 1G', false, ['Vert', 'Rouge', 'Bleu', 'Jaune', 'Rouge Feu', 'Vert Feuille', "Let's Go Pikachu", "Let's Go Évoli"]],
            ['National 2G', false, ['Or', 'Argent', 'Cristal', "HeartGold", "SoulSilver"]],
            ['National 3G', false, ['Rubis', 'Saphir', "Rubis Oméga", "Saphir Alpha"]],
            ['National 4G', false, ['Diamant', 'Perle', "Platine", "Diamant Étincelant", "Perle Scintillante"]],
            ['National 5G', false, ['Noir', 'Blanc', "Noir 2", "Blanc 2"]],
            ['National 6G', false, ['X', 'Y']],
            ['National 7G', false, ['Soleil', 'Lune', "Ultra-Soleil", "Ultra-Lune"]],
            ['HOME', false, ['HOME']],
            ['Kanto', true, ['Vert', 'Rouge', 'Bleu', 'Jaune', 'Rouge Feu', 'Vert Feuille']],
            ['Johto', true, ['Or', 'Argent', 'Cristal']],
            ['Hoenn', true, ['Rubis', 'Saphir']],
            ['Rhodes de Colosseum', true, ['Colosseum']],
            ["Hoenn d'Émeraude", true, ["Émeraude"]],
            ['Rhodes de XD : Le Souffle des Ténèbres', true, ['XD : Le Souffle des Ténèbres']],
            ['Sinnoh', true, ['Diamant', 'Perle']],
            ['Sinnoh de Platine', true, ['Platine']],
            ['Johto de HeartGold & SoulSilver', true, ['HeartGold', 'SoulSilver']],
            ['Unys', true, ['Noir', 'Blanc']],
            ['Unys de Noir 2 & Blanc 2', true, ["Noir 2", "Blanc 2"]],
            ['Kalos', true, ['X', 'Y']],
            ['Hoenn de Rubis Oméga & Saphir Alpha', true, ["Rubis Oméga", "Saphir Alpha"]],
            ['Alola', true, ['Soleil', 'Lune']],
            ['Alola de Ultra-Soleil & Ultra-Lune', true, ["Ultra-Soleil", "Ultra-Lune"]],
            ["Kanto de Let's Go Pikachu & Let's Go Évoli", true, ["Let's Go Pikachu", "Let's Go Évoli"]],
            ['Galar', true, ["Epée", "Bouclier"]],
            ['Galar Zone Isolarmure', true, ["Épée", "Bouclier"]],
            ['Galar Zone Couronneige', true, ["Épée", "Bouclier"]],
            ['Sinnoh de Diamant Étincelant & Perle Scintillante', true, ["Diamant Étincelant", "Perle Scintillante"]],
            ['Hisui de Légendes : Arceus', true, ["Légendes : Arceus"]],
            ['Paldea', true, ["Écarlate", "Violet"]],
        ];

        foreach ($array as $dex) {
            $pokedex = (new Pokedex())
                ->setName($dex[0])
                ->setIsRegional($dex[1])
                ->setIsOnline(true)
                ->setIsShinyUnavailable(false)
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            foreach ($dex[2] as $game) {
                $pokedex->addGame($this->gameRepository->findOneBy(['name' => $game]));
                $manager->persist($pokedex);
            }
            $manager->persist($pokedex);
        }
        $manager->flush();

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
        $manager->flush();

        $pokedex = $this->pokedexRepository->findOneBy(['name' => 'HOME']);
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
