<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PokedexPokemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokedexPokemonRepository::class)]
class PokedexPokemon
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $regionalNumber = null;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pokedex $pokedex = null;

    #[ORM\ManyToOne(inversedBy: 'pokedexEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pokemon $pokemon = null;

    #[ORM\OneToOne(mappedBy: 'pokemon', cascade: ['persist', 'remove'])]
    private ?UserPokedexPokemon $userPokedexPokemon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegionalNumber(): ?int
    {
        return $this->regionalNumber;
    }

    public function setRegionalNumber(?int $regionalNumber): self
    {
        $this->regionalNumber = $regionalNumber;

        return $this;
    }

    public function getPokedex(): ?Pokedex
    {
        return $this->pokedex;
    }

    public function setPokedex(?Pokedex $pokedex): self
    {
        $this->pokedex = $pokedex;

        return $this;
    }

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getUserPokedexPokemon(): ?UserPokedexPokemon
    {
        return $this->userPokedexPokemon;
    }

    public function setUserPokedexPokemon(UserPokedexPokemon $userPokedexPokemon): self
    {
        // set the owning side of the relation if necessary
        if ($userPokedexPokemon->getPokemon() !== $this) {
            $userPokedexPokemon->setPokemon($this);
        }

        $this->userPokedexPokemon = $userPokedexPokemon;

        return $this;
    }
}
