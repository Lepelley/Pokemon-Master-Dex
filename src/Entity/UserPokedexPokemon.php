<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\UserPokedexPokemonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPokedexPokemonRepository::class)]
class UserPokedexPokemon
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isCaptured = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\ManyToOne(inversedBy: 'userPokedexPokemon')]
    private ?Ball $captureBall = null;

    #[ORM\OneToOne(inversedBy: 'userPokedexPokemon', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?PokedexPokemon $pokemon = null;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    private ?Game $captureGame = null;

    #[ORM\ManyToOne(inversedBy: 'pokemon')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserPokedex $pokedex = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsCaptured(): ?bool
    {
        return $this->isCaptured;
    }

    public function setIsCaptured(bool $isCaptured): self
    {
        $this->isCaptured = $isCaptured;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getCaptureBall(): ?Ball
    {
        return $this->captureBall;
    }

    public function setCaptureBall(?Ball $captureBall): self
    {
        $this->captureBall = $captureBall;

        return $this;
    }

    public function getPokemon(): ?PokedexPokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(PokedexPokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getCaptureGame(): ?Game
    {
        return $this->captureGame;
    }

    public function setCaptureGame(?Game $game): self
    {
        $this->captureGame = $game;

        return $this;
    }

    public function getPokedex(): ?UserPokedex
    {
        return $this->pokedex;
    }

    public function setPokedex(?UserPokedex $userPokedex): self
    {
        $this->pokedex = $userPokedex;

        return $this;
    }
}
