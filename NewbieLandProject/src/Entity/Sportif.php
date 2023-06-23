<?php

namespace App\Entity;

use App\Repository\SportifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SportifRepository::class)]
#[Vich\Uploadable]
class Sportif
{

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->actualites = new ArrayCollection();
        $this->palmares = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(targetEntity: Sport::class, cascade: ['persist'], inversedBy: 'sportifs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Sport $sport = null;

    #[ORM\ManyToOne(targetEntity: Delegation::class , cascade: ['persist'], inversedBy: 'sportifs')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Delegation $delegation = null;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: 'sportifs')]
    private Collection $evenements;

    #[ORM\ManyToMany(targetEntity: Actualite::class, mappedBy: 'sportifs')]
    private Collection $actualites;

    #[Vich\UploadableField(mapping: 'sportifs', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: "string", length: 255, nullable: true, enumType: MedalsEnum::class)]
    private ?MedalsEnum $medal = MedalsEnum::DEFAULT;

    #[ORM\OneToMany(mappedBy: 'sportifs', targetEntity: Palmares::class, cascade: ['persist'])]
    private Collection $palmares;

    public function getMedal(): ?MedalsEnum
    {
        return $this->medal;
    }

    public function setMedal(?MedalsEnum $medal): void
    {
        $this->medal = $medal;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getDelegation(): ?Delegation
    {
        return $this->delegation;
    }

    public function setDelegation(?Delegation $delegation): self
    {
        $this->delegation = $delegation;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->addSportif($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            $evenement->removeSportif($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Actualite>
     */
    public function getActualites(): Collection
    {
        return $this->actualites;
    }

    public function addActualite(Actualite $actualite): self
    {
        if (!$this->actualites->contains($actualite)) {
            $this->actualites->add($actualite);
            $actualite->addSportif($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): self
    {
        if ($this->actualites->removeElement($actualite)) {
            $actualite->removeSportif($this);
        }

        return $this;
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * @return Collection<int, Palmares>
     */
    public function getPalmares(): Collection
    {
        return $this->palmares;
    }

    public function addPalmare(Palmares $palmare): self
    {
        if (!$this->palmares->contains($palmare)) {
            $this->palmares->add($palmare);
            $palmare->setSportifs($this);
        }

        return $this;
    }

    public function removePalmare(Palmares $palmare): self
    {
        if ($this->palmares->removeElement($palmare)) {
            // set the owning side to null (unless already changed)
            if ($palmare->getSportifs() === $this) {
                $palmare->setSportifs(null);
            }
        }

        return $this;
    }
}
