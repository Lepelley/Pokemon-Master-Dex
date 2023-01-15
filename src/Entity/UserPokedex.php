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

    #[ORM\ManyToOne(inversedBy: 'allUsersPokedex')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pokedex $pokedex = null;

    #[ORM\ManyToOne(inversedBy: 'pokedex')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $trainer = null;

    #[ORM\OneToMany(mappedBy: 'pokedex', targetEntity: UserPokedexPokemon::class, orphanRemoval: true)]
    private Collection $pokemon;

    private ?int $pokemonCaught = null;

    private ?int $pokemonCaughtPerCent = null;

    #[ORM\Column]
    private ?bool $preventSpoil = null;

    public function __construct()
    {
        $this->pokemon = new ArrayCollection();
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

    /**
     * @return Collection<int, UserPokedexPokemon>
     */
    public function getPokemon(): Collection
    {
        return $this->pokemon;
    }

    public function addPokemon(UserPokedexPokemon $pokemon): self
    {
        if (!$this->pokemon->contains($pokemon)) {
            $this->pokemon->add($pokemon);
            $pokemon->setPokedex($this);
        }

        return $this;
    }

    public function removePokemon(UserPokedexPokemon $pokemon): self
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getPokedex() === $this) {
                $pokemon->setPokedex(null);
            }
        }

        return $this;
    }

    public function getPokemonCaught(): ?int
    {
        return $this->pokemonCaught;
    }

    public function setPokemonCaught(?int $pokemonCaught): self
    {
        $this->pokemonCaught = $pokemonCaught;

        return $this;
    }

    public function getPokemonCaughtPerCent(): ?int
    {
        return $this->pokemonCaughtPerCent;
    }

    public function setPokemonCaughtPerCent(int $caught): self
    {
        if (0 === $this->getPokemon()->count()) {
            $this->pokemonCaughtPerCent = 0;

            return $this;
        }
        $this->pokemonCaughtPerCent = ceil($caught * 100 / $this->getPokemon()->count());

        return $this;
    }

    public function isPreventSpoil(): ?bool
    {
        return $this->preventSpoil;
    }

    public function setPreventSpoil(bool $preventSpoil): self
    {
        $this->preventSpoil = $preventSpoil;

        return $this;
    }
}
