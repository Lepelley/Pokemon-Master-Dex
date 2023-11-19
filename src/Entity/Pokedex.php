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

    #[ORM\Column]
    private ?bool $isShinyUnavailable = null;

    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'pokedex')]
    private Collection $games;

    #[ORM\OrderBy(["nationalNumber" => "ASC"])]
    #[ORM\ManyToMany(targetEntity: PokemonForm::class, inversedBy: 'pokedex')]
    private Collection $pokemonForms;

    public function __construct()
    {
        $this->pokemon = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->pokemonForms = new ArrayCollection();
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

    public function isShinyUnavailable(): ?bool
    {
        return $this->isShinyUnavailable;
    }

    public function setIsShinyUnavailable(bool $isShinyUnavailable): self
    {
        $this->isShinyUnavailable = $isShinyUnavailable;

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
     * @return Collection<int, PokemonForm>
     */
    public function getPokemonForms(): Collection
    {
        return $this->pokemonForms;
    }

    public function addPokemonForm(PokemonForm $pokemonForm): self
    {
        if (!$this->pokemonForms->contains($pokemonForm)) {
            $this->pokemonForms->add($pokemonForm);
        }

        return $this;
    }

    public function removePokemonForm(PokemonForm $pokemonForm): self
    {
        $this->pokemonForms->removeElement($pokemonForm);

        return $this;
    }
}
