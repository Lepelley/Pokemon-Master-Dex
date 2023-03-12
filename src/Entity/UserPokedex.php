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

    #[ORM\Column]
    private ?bool $preventSpoil = null;

    private ?int $pokemonCaught = null;

    private ?int $pokemonCount = null;

    private ?int $pokemonCaughtPerCent = null;

    #[ORM\ManyToOne(inversedBy: 'userPokedex')]
    private ?Game $baseGame = null;

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
        if (null === $this->pokemonCaught) {
            $this->pokemonCaught = 0;
            /** @var UserPokedexPokemon $pokemon */
            foreach ($this->pokemon as $pokemon) {
                if (
                    ($pokemon->isCaptured() && false  === $this->isShiny) ||
                    $pokemon->isCaptured() && $this->isShiny && ($pokemon->getPokemon() && false === $pokemon->getPokemon()->isShinyUnavailable()) ||
                    $pokemon->isCaptured() && $this->isShiny && $pokemon->getForm()
                ) {
                    $this->pokemonCaught++;
                }
            }
        }

        return $this->pokemonCaught;
    }

    public function getPokemonCaughtPerCent(): ?int
    {
        if (0 === $this->getPokemon()->count()) {
            return 0;
        }
        if (null === $this->pokemonCaughtPerCent) {
            $this->pokemonCaughtPerCent = ceil($this->pokemonCaught * 100 / $this->pokemonCount);
        }

        return $this->pokemonCaughtPerCent;
    }

    public function getPokemonCount(): int
    {
        if (0 === $this->getPokemon()->count()) {
            return 0;
        }

        if (null === $this->pokemonCount) {
            if (false === $this->isShiny) {
                $this->pokemonCount = $this->getPokemon()->count();

                return $this->pokemonCount;
            }

            $total = 0;
            foreach ($this->getPokemon() as $pokemon) {
                if ($pokemon->getPokemon() && false === $pokemon->getPokemon()->isShinyUnavailable()) {
                    $total++;
                }
                if ($pokemon->getForm()) {
                    $total++;
                }
            }

            $this->pokemonCount = $total;
        }

        return $this->pokemonCount;
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

    public function getBaseGame(): ?Game
    {
        return $this->baseGame;
    }

    public function setBaseGame(?Game $baseGame): self
    {
        $this->baseGame = $baseGame;

        return $this;
    }
}
