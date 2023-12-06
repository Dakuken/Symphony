<?php

namespace App\Entity;

use App\Repository\PainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PainRepository::class)]
class Pain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'pain', targetEntity: Burger::class)]
    private Collection $burger;

    public function __construct()
    {
        $this->burger = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurger(): Collection
    {
        return $this->burger;
    }

    public function addBurger(Burger $burger): static
    {
        if (!$this->burger->contains($burger)) {
            $this->burger->add($burger);
            $burger->setPain($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): static
    {
        if ($this->burger->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getPain() === $this) {
                $burger->setPain(null);
            }
        }

        return $this;
    }
}
