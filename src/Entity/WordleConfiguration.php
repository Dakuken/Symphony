<?php
// src/Entity/Wordle.php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\WordleConfigurationRepository;
use App\Validator\IsInWordleDictionary;

#[ORM\Entity(repositoryClass: WordleConfigurationRepository::class)]
class WordleConfiguration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    
    #[ORM\Column(type: 'string')]
    #[IsInWordleDictionary]
    private string $solution;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(
        min: 3,
        max: 8,
        notInRangeMessage: 'Le nombre d\'essais doit être entre {{ min }} et {{ max }}.'
    )]
    private int $maxTries;

    #[ORM\Column(type: 'integer')]
    private int $wordLength;

// Relation avec l'utilisateur (auteur du wordle)
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

// Getters et Setters pour chaque propriété
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolution(): string
    {
        return $this->solution;
    }

    public function setSolution(string $solution): self
    {
        $this->solution = $solution;
        return $this;
    }

    public function getMaxTries(): int
    {
        return $this->maxTries;
    }

    public function setMaxTries(int $maxTries): self
    {
        $this->maxTries = $maxTries;
        return $this;
    }

    public function getWordLength(): int
    {
        return $this->wordLength;
    }

    public function setWordLength(int $wordLength): self
    {
        $this->wordLength = $wordLength;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }
}
