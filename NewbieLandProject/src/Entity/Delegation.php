<?php

namespace App\Entity;

use App\Repository\DelegationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelegationRepository::class)]
class Delegation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'delegation', targetEntity: Sportif::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $sportifs;

    public function __construct()
    {
        $this->sportifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Sportif>
     */
    public function getSportifs(): Collection
    {
        return $this->sportifs;
    }

    public function addSportif(Sportif $sportif): self
    {
        if (!$this->sportifs->contains($sportif)) {
            $this->sportifs->add($sportif);
            $sportif->setDelegation($this);
        }

        return $this;
    }

    public function removeSportif(Sportif $sportif): self
    {
        if ($this->sportifs->removeElement($sportif)) {
            // set the owning side to null (unless already changed)
            if ($sportif->getDelegation() === $this) {
                $sportif->setDelegation(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
