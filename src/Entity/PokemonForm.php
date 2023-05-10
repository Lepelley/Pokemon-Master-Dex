<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\OnlineTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\PokemonFormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonFormRepository::class)]
class PokemonForm
{
    use OnlineTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: PokedexPokemon::class, orphanRemoval: true)]
    private Collection $pokedexEntries;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageShiny = null;

    #[ORM\ManyToOne(inversedBy: 'forms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pokemon $pokemon = null;

    #[ORM\Column]
    private ?bool $isGenderDifference = null;

    #[ORM\ManyToMany(targetEntity: Pokedex::class, mappedBy: 'pokemonForms')]
    private Collection $pokedex;

    #[ORM\OneToMany(mappedBy: 'form', targetEntity: UserPokedexPokemon::class)]
    private Collection $userPokemon;

    #[ORM\Column(nullable: true)]
    private ?int $nationalNumber = null;

    public function __construct()
    {
        $this->pokedexEntries = new ArrayCollection();
        $this->pokedex = new ArrayCollection();
        $this->userPokemon = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageShiny(): ?string
    {
        return $this->imageShiny;
    }

    public function setImageShiny(?string $imageShiny): self
    {
        $this->imageShiny = $imageShiny;

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

    public function isIsGenderDifference(): ?bool
    {
        return $this->isGenderDifference;
    }

    public function setIsGenderDifference(bool $isGenderDifference): self
    {
        $this->isGenderDifference = $isGenderDifference;

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
            $pokedex->addPokemonForm($this);
        }

        return $this;
    }

    public function removePokedex(Pokedex $pokedex): self
    {
        if ($this->pokedex->removeElement($pokedex)) {
            $pokedex->removePokemonForm($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPokedexPokemon>
     */
    public function getUserPokemon(): Collection
    {
        return $this->userPokemon;
    }

    public function addUserPokemon(UserPokedexPokemon $userPokemon): self
    {
        if (!$this->userPokemon->contains($userPokemon)) {
            $this->userPokemon->add($userPokemon);
            $userPokemon->setForm($this);
        }

        return $this;
    }

    public function removeUserPokemon(UserPokedexPokemon $userPokemon): self
    {
        if ($this->userPokemon->removeElement($userPokemon)) {
            // set the owning side to null (unless already changed)
            if ($userPokemon->getForm() === $this) {
                $userPokemon->setForm(null);
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
