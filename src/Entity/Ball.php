<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\OnlineTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\BallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BallRepository::class)]
class Ball
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

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'balls')]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'captureBall', targetEntity: UserPokedexPokemon::class)]
    private Collection $userPokedexPokemon;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->userPokedexPokemon = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->games->removeElement($game);

        return $this;
    }

    /**
     * @return Collection<int, UserPokedexPokemon>
     */
    public function getUserPokedexPokemon(): Collection
    {
        return $this->userPokedexPokemon;
    }

    public function addUserPokedexPokemon(UserPokedexPokemon $userPokedexPokemon): self
    {
        if (!$this->userPokedexPokemon->contains($userPokedexPokemon)) {
            $this->userPokedexPokemon->add($userPokedexPokemon);
            $userPokedexPokemon->setCaptureBall($this);
        }

        return $this;
    }

    public function removeUserPokedexPokemon(UserPokedexPokemon $userPokedexPokemon): self
    {
        if ($this->userPokedexPokemon->removeElement($userPokedexPokemon)) {
            // set the owning side to null (unless already changed)
            if ($userPokedexPokemon->getCaptureBall() === $this) {
                $userPokedexPokemon->setCaptureBall(null);
            }
        }

        return $this;
    }
}
