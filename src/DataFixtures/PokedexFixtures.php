<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Repository\PokedexRepository;
use App\Repository\PokemonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PokedexFixtures extends Fixture
{
    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
        private readonly PokedexRepository $pokedexRepository,
    ) {}

    public function load(ObjectManager $manager)
    {
        $time = new \DateTimeImmutable();

        $data = [
            // nom du dex, nom du csv, colonne du regional dex, forme #001 ?, colonne du nom du poké
            ['Institut Myrtille (EV DLC 2)', 'blueberry.csv', 0, false, 2],
            ['Institut Myrtille Master Dex (EV DLC 2)', 'blueberry.csv', 0, false, 2],
            ['Septentria (EV DLC 1)', 'kitakami.csv', 0, false, 2],
            ['Septentria Master Dex (EV DLC 1)', 'kitakami.csv', 0, false, 2],
            ['Paldea', 'paldea.csv', 0, true, 2],
            ['Paldea Master Dex', 'paldea.csv', 0, true, 2],
            ['Hisui de Légendes : Arceus', 'hisui.csv', 0, false, 2],
            ['Hisui de Légendes : Arceus Master Dex', 'hisui.csv', 0, false, 2],
            ['Sinnoh de Diamant Étincelant & Perle Scintillante', 'sinnoh.csv', 0, true, 2],
            ['Couronneige (EB DLC 2)', 'couronneige.csv', 0, true, 2],
            ['Couronneige Master Dex (EB DLC 2)', 'couronneige.csv', 0, true, 2],
            ['Isolarmure (EB DLC 1)', 'isolarmure.csv', 0, true, 2],
            ['Isolarmure Master Dex (EB DLC 1)', 'isolarmure.csv', 0, true, 2],
            ['Galar', 'galar.csv', 0, true, 2],
            ['Galar Master Dex', 'galar.csv', 0, true, 2],
            ["Kanto de Let's Go Pikachu & Let's Go Évoli", 'lgpe.csv', 0, true, 2],
            ["Kanto de Let's Go Pikachu & Let's Go Évoli Master Dex", 'lgpe.csv', 0, true, 2],
            ["Alola de Ultra-Soleil & Ultra-Lune", 'usum.csv', 0, true, 2],
            ["Alola", 'sunmoon.csv', 0, false, 2],
            ["Hoenn de Rubis Oméga & Saphir Alpha", 'rosa.csv', 0, false, 3],
            ['Kalos : monts', 'xy-monts.csv', 0, false, 3],
            ['Kalos : côte', 'xy-cotes.csv', 0, false, 3],
            ['Kalos : centre', 'xy-centre.csv', 0, false, 3],
            ['Unys de Noir 2 & Blanc 2', 'b2w2.csv', 0, false, 2],
            ['Unys', 'unys.csv', 0, false, 2],
            ['Johto de HeartGold & SoulSilver', 'hgss.csv', 0, false, 1],
            ['Sinnoh de Platine', 'platine.csv', 0, false, 2],
            ['Sinnoh', 'diamond-pearl.csv', 0, false, 2],
            ['Rhodes de XD : Le Souffle des Ténèbres', 'xd.csv', 10, false, 1],
            ['Rhodes de Colosseum', 'colosseum.csv', 10, false, 1],
            ["Hoenn", 'emeraude.csv', 0, false, 1],
            ['Johto', 'gsc.csv', 0, false, 2],
            ['Kanto', 'kanto.csv', 0, false, 1],
        ];

        foreach ($data as $r) {
            $pokedex = $this->pokedexRepository->findOneBy(['name' => $r[0]]);
            $fileHandle = fopen("var/csv/".$r[1], "r");
            while (($row = fgetcsv($fileHandle, 0, ",")) !== false) {
                $pokemon = (new PokedexPokemon())
                    ->setRegionalNumber($r[3] ? (int) substr($row[$r[2]], 1) : $r[2])
                    ->setPokemon($this->pokemonRepository->findOneBy(['name' => $row[$r[4]]]))
                    ->setIsShinyUnavailable(false)
                    ->setCreatedAt($time)
                    ->setUpdatedAt($time)
                    ->setPokedex($pokedex)
                ;
                if ($this->pokemonRepository->findOneBy(['name' => $row[$r[4]]]) === null) {
                    dump($row);
                }
                $manager->persist($pokemon);
            }
            $manager->flush();
        }
    }
}
