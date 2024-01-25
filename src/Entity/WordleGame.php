<?php

namespace App\Entity;

use App\Repository\WordleGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WordleGameRepository::class)]
class WordleGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: WordleConfiguration::class)]
    #[ORM\JoinColumn(name: "wordle_configuration_id", referencedColumnName: "id")]
    private $wordleConfiguration;

    #[ORM\ManyToMany(targetEntity: WordlePlayer::class, inversedBy: "games")]
    #[ORM\JoinTable(name: "wordle_game_players")]
    private $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    // Getters et setters pour players
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    // Getters et setters
    public function getWordleConfiguration(): ?WordleConfiguration
    {
        return $this->wordleConfiguration;
    }

    public function setWordleConfiguration(?WordleConfiguration $wordleConfiguration): self
    {
        $this->wordleConfiguration = $wordleConfiguration;
        return $this;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
