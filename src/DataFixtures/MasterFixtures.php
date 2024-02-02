<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Pokedex;
use App\Entity\PokedexPokemon;
use App\Entity\PokemonForm;
use App\Repository\PokedexRepository;
use App\Repository\PokemonFormRepository;
use App\Repository\PokemonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MasterFixtures extends Fixture
{
    public function __construct(
        private readonly PokemonFormRepository $pokemonFormRepository,
        private readonly PokedexRepository $pokedexRepository,
        private readonly PokemonRepository $pokemonRepository,
    ) {}

    public function load(ObjectManager $manager)
    {
        $time = new \DateTimeImmutable();

        $data = [
            ['National 1G Master Dex', '3g.csv'],
            ['National 2G Master Dex', '2g.csv'],
            ['National 3G Master Dex', '3g.csv'],
            ['National 4G Master Dex', '4g.csv'],
            ['National 5G Master Dex', '5g.csv'],
            ['National 6G Master Dex', '6g.csv'],
            ['National 7G Master Dex', '7g.csv'],
            ["Kanto de Let's Go Pikachu & Let's Go Évoli Master Dex", 'lgpe.csv'],
            ["Galar Master Dex", 'galar.csv'],
            ["Isolarmure Master Dex (EB DLC 1)", 'isolarmure.csv'],
            ["Couronneige Master Dex (EB DLC 2)", 'couronneige.csv'],
            ["Hisui de Légendes : Arceus Master Dex", 'hisui.csv'],
            ["Paldea Master Dex", 'paldea.csv'],
            ["Septentria Master Dex (EV DLC 1)", 'kitakami.csv'],
            ["Institut Myrtille Master Dex (EV DLC 2)", 'blueberry.csv'],
            ["HOME Master Dex", 'home.csv'],
        ];

        foreach ($data as $r) {
            $pokedex = $this->pokedexRepository->findOneBy(['name' => $r[0]]);
            if (null === $pokedex) {
                dump($r[0]);
            }
            $fileHandle = fopen("var/csv/pokemon/".$r[1], "r");
            while (($row = fgetcsv($fileHandle, 0, ",")) !== false) {
                if ('' === trim($row[2])) {
                    $forms = $this->pokemonRepository->findOneBy(['nationalNumber' => trim($row[0])])->getForms();
                    foreach ($forms as $formTemp) {
                        if ($formTemp->isIsGenderDifference()) {
                            $form = $formTemp;
                        }
                    }
                } else {
                    $form = $this->pokemonFormRepository->findOneBy(['name' => trim($row[2])]);
                }
                if (null === $form) {
                    dump($row[2]);
                }
                $pokedex->addPokemonForm($form);
                $form->addPokedex($pokedex);

                $manager->persist($pokedex);
                $manager->persist($form);
            }
            $manager->flush();
        }
    }
}
