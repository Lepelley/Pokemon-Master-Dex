<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\OnlineTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
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

    #[ORM\ManyToMany(targetEntity: Ball::class, mappedBy: 'captureGame')]
    private Collection $balls;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: UserPokedexPokemon::class)]
    private Collection $pokemon;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Pokedex $pokedex = null;

    public function __construct()
    {
        $this->balls = new ArrayCollection();
        $this->pokemon = new ArrayCollection();
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
     * @return Collection<int, Ball>
     */
    public function getBalls(): Collection
    {
        return $this->balls;
    }

    public function addBall(Ball $ball): self
    {
        if (!$this->balls->contains($ball)) {
            $this->balls->add($ball);
            $ball->addGame($this);
        }

        return $this;
    }

    public function removeBall(Ball $ball): self
    {
        if ($this->balls->removeElement($ball)) {
            $ball->removeGame($this);
        }

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
            $pokemon->setGame($this);
        }

        return $this;
    }

    public function removePokemon(UserPokedexPokemon $pokemon): self
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getGame() === $this) {
                $pokemon->setGame(null);
            }
        }

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
