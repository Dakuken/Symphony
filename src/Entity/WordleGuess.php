<?php

namespace App\Entity;

use App\Repository\WordleGuessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordleGuessRepository::class)]
class WordleGuess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $guessedWord = null;

    #[ORM\Column]
    private ?int $guessNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuessedWord(): ?string
    {
        return $this->guessedWord;
    }

    public function setGuessedWord(string $guessedWord): static
    {
        $this->guessedWord = $guessedWord;

        return $this;
    }

    public function getGuessNumber(): ?int
    {
        return $this->guessNumber;
    }

    public function setGuessNumber(int $guessNumber): static
    {
        $this->guessNumber = $guessNumber;

        return $this;
    }
}
