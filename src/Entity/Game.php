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

    #[ORM\ManyToMany(targetEntity: Ball::class, mappedBy: 'games')]
    private Collection $balls;

    #[ORM\OneToMany(mappedBy: 'captureGame', targetEntity: UserPokedexPokemon::class)]
    private Collection $pokemon;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $releaseDate = null;

    #[ORM\OneToMany(mappedBy: 'baseGame', targetEntity: UserPokedex::class)]
    private Collection $userPokedex;

    #[ORM\ManyToMany(targetEntity: Pokedex::class, mappedBy: 'games')]
    private Collection $pokedex;

    public function __construct()
    {
        $this->balls = new ArrayCollection();
        $this->pokemon = new ArrayCollection();
        $this->userPokedex = new ArrayCollection();
        $this->pokedex = new ArrayCollection();
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

    public function getReleaseDate(): ?\DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeImmutable $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Collection<int, UserPokedex>
     */
    public function getUserPokedex(): Collection
    {
        return $this->userPokedex;
    }

    public function addUserPokedex(UserPokedex $userPokedex): self
    {
        if (!$this->userPokedex->contains($userPokedex)) {
            $this->userPokedex->add($userPokedex);
            $userPokedex->setBaseGame($this);
        }

        return $this;
    }

    public function removeUserPokedex(UserPokedex $userPokedex): self
    {
        if ($this->userPokedex->removeElement($userPokedex)) {
            // set the owning side to null (unless already changed)
            if ($userPokedex->getBaseGame() === $this) {
                $userPokedex->setBaseGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pokedex>
     */
    public function getPokedex(): Collection
    {
        return $this->pokedex;
    }

    public function addPokedex(Pokedex $pokedex): self
    {
        if (!$this->pokedex->contains($pokedex)) {
            $this->pokedex->add($pokedex);
            $pokedex->addGame($this);
        }

        return $this;
    }

    public function removePokedex(Pokedex $pokedex): self
    {
        if ($this->pokedex->removeElement($pokedex)) {
            $pokedex->removeGame($this);
        }

        return $this;
    }
}
