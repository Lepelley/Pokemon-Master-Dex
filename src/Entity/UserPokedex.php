<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\UserPokedexRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPokedexRepository::class)]
class UserPokedex
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isShiny = null;

    #[ORM\OneToMany(mappedBy: 'pokedex', targetEntity: UserPokedexPokemon::class, orphanRemoval: true)]
    private Collection $userPokedexPokemon;

    #[ORM\ManyToOne(inversedBy: 'allUsersPokedex')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pokedex $pokedex = null;

    #[ORM\ManyToOne(inversedBy: 'pokedex')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $trainer = null;

    public function __construct()
    {
        $this->userPokedexPokemon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainer(): ?User
    {
        return $this->trainer;
    }

    public function setTrainer(?User $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isShiny(): ?bool
    {
        return $this->isShiny;
    }

    public function setIsShiny(bool $isShiny): self
    {
        $this->isShiny = $isShiny;

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
}
