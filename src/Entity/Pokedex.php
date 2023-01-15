<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\OnlineTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PokedexRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokedexRepository::class)]
class Pokedex
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

    #[ORM\Column]
    private ?bool $isRegional = null;

    #[ORM\OneToMany(mappedBy: 'pokedex', targetEntity: PokedexPokemon::class, orphanRemoval: true)]
    private Collection $pokemon;

    #[ORM\OneToMany(mappedBy: 'pokedex', targetEntity: UserPokedex::class, orphanRemoval: true)]
    private Collection $allUsersPokedex;

    #[ORM\OneToMany(mappedBy: 'pokedex', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\Column]
    private ?bool $isShinyUnavailable = null;

    public function __construct()
    {
        $this->pokemon = new ArrayCollection();
        $this->allUsersPokedex = new ArrayCollection();
        $this->games = new ArrayCollection();
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

    public function isRegional(): ?bool
    {
        return $this->isRegional;
    }

    public function setIsRegional(bool $isRegional): self
    {
        $this->isRegional = $isRegional;

        return $this;
    }

    /**
     * @return Collection<int, PokedexPokemon>
     */
    public function getPokemon(): Collection
    {
        return $this->pokemon;
    }

    public function addPokemon(PokedexPokemon $pokemon): self
    {
        if (!$this->pokemon->contains($pokemon)) {
            $this->pokemon->add($pokemon);
            $pokemon->setPokedex($this);
        }

        return $this;
    }

    public function removePokemon(PokedexPokemon $pokemon): self
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getPokedex() === $this) {
                $pokemon->setPokedex(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPokedex>
     */
    public function getAllUsersPokedex(): Collection
    {
        return $this->allUsersPokedex;
    }

    public function addAllUsersPokedex(UserPokedex $allUsersPokedex): self
    {
        if (!$this->allUsersPokedex->contains($allUsersPokedex)) {
            $this->allUsersPokedex->add($allUsersPokedex);
            $allUsersPokedex->setPokedex($this);
        }

        return $this;
    }

    public function removeAllUsersPokedex(UserPokedex $allUsersPokedex): self
    {
        if ($this->allUsersPokedex->removeElement($allUsersPokedex)) {
            // set the owning side to null (unless already changed)
            if ($allUsersPokedex->getPokedex() === $this) {
                $allUsersPokedex->setPokedex(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setPokedex($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getPokedex() === $this) {
                $game->setPokedex(null);
            }
        }

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
