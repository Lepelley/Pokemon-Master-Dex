<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\OnlineTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    use OnlineTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: PokedexPokemon::class, orphanRemoval: true)]
    private Collection $pokedexEntries;

    #[ORM\Column(nullable: true)]
    private ?int $nationalNumber = null;

    public function __construct()
    {
        $this->pokedexEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, PokedexPokemon>
     */
    public function getPokedexEntries(): Collection
    {
        return $this->pokedexEntries;
    }

    public function addPokedexEntry(PokedexPokemon $pokedexEntry): self
    {
        if (!$this->pokedexEntries->contains($pokedexEntry)) {
            $this->pokedexEntries->add($pokedexEntry);
            $pokedexEntry->setPokemon($this);
        }

        return $this;
    }

    public function removePokedexEntry(PokedexPokemon $pokedexEntry): self
    {
        if ($this->pokedexEntries->removeElement($pokedexEntry)) {
            // set the owning side to null (unless already changed)
            if ($pokedexEntry->getPokemon() === $this) {
                $pokedexEntry->setPokemon(null);
            }
        }

        return $this;
    }

    public function getNationalNumber(): ?int
    {
        return $this->nationalNumber;
    }

    public function setNationalNumber(?int $nationalNumber): self
    {
        $this->nationalNumber = $nationalNumber;

        return $this;
    }
}
