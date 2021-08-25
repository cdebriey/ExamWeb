<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("voiture:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Marque;
    
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $PrixDemande;
    
    /**
     * @ORM\Column(type="string", length=1000)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Image;
    
    
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Kilometrage;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Cylindree;

   
    
    /**
     * @ORM\Column(type="text")
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Description;
    
    /**
     * @ORM\Column(type="datetime")
     * @Groups("voiture:read")
     *
     */
    private $MiseEnVente;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="voiture", cascade={"remove"})
     * 
     */
    private $offres;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $AnneeDeMiseEnCirculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Modele;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("voiture:read")
     * @Assert\NotBlank
     */
    private $Puissance;


    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getPrixDemande(): ?int
    {
        return $this->PrixDemande;
    }

    public function setPrixDemande(int $PrixDemande): self
    {
        $this->PrixDemande = $PrixDemande;

        return $this;
    }

    public function getMiseEnVente(): ?\DateTimeInterface
    {
        return $this->MiseEnVente;
    }

    public function setMiseEnVente(\DateTimeInterface $MiseEnVente): self
    {
        $this->MiseEnVente = $MiseEnVente;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->Kilometrage;
    }

    public function setKilometrage(int $Kilometrage): self
    {
        $this->Kilometrage = $Kilometrage;

        return $this;
    }

    public function getCylindree(): ?int
    {
        return $this->Cylindree;
    }

    public function setCylindree(int $Cylindree): self
    {
        $this->Cylindree = $Cylindree;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setVoiture($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getVoiture() === $this) {
                $offre->setVoiture(null);
            }
        }

        return $this;
    }

    public function getAnneeDeMiseEnCirculation(): ?int
    {
        return $this->AnneeDeMiseEnCirculation;
    }

    public function setAnneeDeMiseEnCirculation(int $AnneeDeMiseEnCirculation): self
    {
        $this->AnneeDeMiseEnCirculation = $AnneeDeMiseEnCirculation;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->Modele;
    }

    public function setModele(string $Modele): self
    {
        $this->Modele = $Modele;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->Puissance;
    }

    public function setPuissance(?int $Puissance): self
    {
        $this->Puissance = $Puissance;

        return $this;
    }
/*
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
*/
}
