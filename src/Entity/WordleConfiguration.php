<?php

namespace App\Entity;

use App\Repository\WordleConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordleConfigurationRepository::class)]
class WordleConfiguration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $wordLength = null;

    #[ORM\Column]
    private ?int $maxGuess = null;

    #[ORM\OneToMany(mappedBy: "wordleConfiguration", targetEntity: WordleGame::class)]
    private $wordleGames;

    public function __construct()
    {
        $this->wordleGames = new ArrayCollection();
    }

    // Getters et setters pour wordleGames
    public function getWordleGames(): Collection
    {
        return $this->wordleGames;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWordLength(): ?int
    {
        return $this->wordLength;
    }

    public function setWordLength(int $wordLength): static
    {
        $this->wordLength = $wordLength;

        return $this;
    }

    public function getMaxGuess(): ?int
    {
        return $this->maxGuess;
    }

    public function setMaxGuess(int $maxGuess): static
    {
        $this->maxGuess = $maxGuess;

        return $this;
    }

    public function getWordleGameId(): ?int
    {
        return $this->wordleGame_id;
    }
    
}
