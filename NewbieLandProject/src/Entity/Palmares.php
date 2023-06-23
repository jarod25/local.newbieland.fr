<?php

namespace App\Entity;

use App\Repository\PalmaresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PalmaresRepository::class)]
class Palmares
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $competition = null;

    #[ORM\Column(type: "string", length: 255, nullable: true, enumType: MedalsEnum::class)]
    private MedalsEnum $position = MedalsEnum::DEFAULT;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $annee = null;

    #[ORM\ManyToOne(inversedBy: 'palmares')]
    private ?Sportif $sportifs = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetition(): ?string
    {
        return $this->competition;
    }

    public function setCompetition(?string $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getPosition(): ?MedalsEnum
    {
        return $this->position;
    }

    public function setPosition(MedalsEnum $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getSportifs(): ?Sportif
    {
        return $this->sportifs;
    }

    public function setSportifs(?Sportif $sportifs): self
    {
        $this->sportifs = $sportifs;

        return $this;
    }

    public function __toString(): string
    {
        return 'A la compétition ' . $this->competition . ', ce sportif à eu ' . $this->position->getLabel() . ' en ' . $this->annee->format('Y');
    }
}
