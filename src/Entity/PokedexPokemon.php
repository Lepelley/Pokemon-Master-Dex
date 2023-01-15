<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PokedexPokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: UserPokedexPokemon::class, orphanRemoval: true)]
    private Collection $usersPokemon;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specificName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specificImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specificShinyImage = null;

    #[ORM\Column]
    private ?bool $isShinyUnavailable = null;

    public function __construct()
    {
        $this->usersPokemon = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, UserPokedexPokemon>
     */
    public function getUsersPokemon(): Collection
    {
        return $this->usersPokemon;
    }

    public function addUsersPokemon(UserPokedexPokemon $usersPokemon): self
    {
        if (!$this->usersPokemon->contains($usersPokemon)) {
            $this->usersPokemon->add($usersPokemon);
            $usersPokemon->setPokemon($this);
        }

        return $this;
    }

    public function removeUsersPokemon(UserPokedexPokemon $usersPokemon): self
    {
        if ($this->usersPokemon->removeElement($usersPokemon)) {
            // set the owning side to null (unless already changed)
            if ($usersPokemon->getPokemon() === $this) {
                $usersPokemon->setPokemon(null);
            }
        }

        return $this;
    }

    public function getSpecificName(): ?string
    {
        return $this->specificName;
    }

    public function setSpecificName(?string $specificName): self
    {
        $this->specificName = $specificName;

        return $this;
    }

    public function getSpecificImage(): ?string
    {
        return $this->specificImage;
    }

    public function setSpecificImage(?string $specificImage): self
    {
        $this->specificImage = $specificImage;

        return $this;
    }

    public function getSpecificShinyImage(): ?string
    {
        return $this->specificShinyImage;
    }

    public function setSpecificShinyImage(?string $specificShinyImage): self
    {
        $this->specificShinyImage = $specificShinyImage;

        return $this;
    }

    public function isIsShinyUnavailable(): ?bool
    {
        return $this->isShinyUnavailable;
    }

    public function setIsShinyUnavailable(bool $isShinyUnavailable): self
    {
        $this->isShinyUnavailable = $isShinyUnavailable;

        return $this;
    }
}
