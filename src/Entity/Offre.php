<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
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
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("voiture:read")
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("voiture:read")
     */
    private $AdresseEmail;

    /**
     * @ORM\Column(type="integer")
     * @Groups("voiture:read")
     */
    private $PrixOffert;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $CreatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="offres")
     */
    private $voiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getAdresseEmail(): ?string
    {
        return $this->AdresseEmail;
    }

    public function setAdresseEmail(?string $AdresseEmail): self
    {
        $this->AdresseEmail = $AdresseEmail;

        return $this;
    }

    public function getPrixOffert(): ?int
    {
        return $this->PrixOffert;
    }

    public function setPrixOffert(int $PrixOffert): self
    {
        $this->PrixOffert = $PrixOffert;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
