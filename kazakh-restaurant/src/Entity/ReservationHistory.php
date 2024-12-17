<?php

namespace App\Entity;

use App\Repository\ReservationHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationHistoryRepository::class)]
class ReservationHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $clientName = null;

    #[ORM\Column(length: 255)]
    private ?string $clientEmail = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAccepted = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateReservation = null;

    #[ORM\Column(length: 255)]
    private ?string $ReservationType = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $plat = null;

    
    #[ORM\Column(length: 255, nullable:true)]
    private ?string $entree = null;

    #[ORM\Column(nullable:true)]
    private ?int $QteEntree = null;

    #[ORM\Column(nullable:true)]
    private ?int $QtePlat = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $Boisson = null;

    #[ORM\Column(nullable:true)]
    private ?int $QteBoisson = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $dessert = null;

    #[ORM\Column(nullable:true)]
    private ?int $qteDessert = null;
    

    #[ORM\ManyToOne(inversedBy: 'reservationHistories')]
    private ?Employe $Employe = null;

    #[ORM\ManyToOne(inversedBy: 'reservationHistories')]
    private ?Commande $Commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getClientEmail(): ?string
    {
        return $this->clientEmail;
    }

    public function setClientEmail(string $clientEmail): static
    {
        $this->clientEmail = $clientEmail;

        return $this;
    }

  

    public function getDateAccepted(): ?\DateTimeInterface
    {
        return $this->dateAccepted;
    }

    public function setDateAccepted(\DateTimeInterface $dateAccepted): static
    {
        $this->dateAccepted = $dateAccepted;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->DateReservation;
    }

    public function setDateReservation(\DateTimeInterface $DateReservation): static
    {
        $this->DateReservation = $DateReservation;

        return $this;
    }

    public function getReservationType(): ?string
    {
        return $this->ReservationType;
    }

    public function setReservationType(string $ReservationType): static
    {
        $this->ReservationType = $ReservationType;

        return $this;
    }

    public function getPlat(): ?string
    {
        return $this->plat;
    }

    public function setPlat(string $plat): static
    {
        $this->plat = $plat;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->Employe;
    }

    public function setEmploye(?Employe $Employe): static
    {
        $this->Employe = $Employe;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): static
    {
        $this->Commande = $Commande;

        return $this;
    }

    
    public function getEntree(): ?string
    {
        return $this->entree;
    }

    public function setEntree(string $entree): static
    {
        $this->entree = $entree;

        return $this;
    }

    public function getQteEntree(): ?int
    {
        return $this->QteEntree;
    }

    public function setQteEntree(int $QteEntree): static
    {
        $this->QteEntree = $QteEntree;

        return $this;
    }

    public function getQtePlat(): ?int
    {
        return $this->QtePlat;
    }

    public function setQtePlat(int $QtePlat): static
    {
        $this->QtePlat = $QtePlat;

        return $this;
    }

    public function getBoisson(): ?string
    {
        return $this->Boisson;
    }

    public function setBoisson(string $Boisson): static
    {
        $this->Boisson = $Boisson;

        return $this;
    }

    public function getQteBoisson(): ?int
    {
        return $this->QteBoisson;
    }

    public function setQteBoisson(int $QteBoisson): static
    {
        $this->QteBoisson = $QteBoisson;

        return $this;
    }

    public function getDessert(): ?string
    {
        return $this->dessert;
    }

    public function setDessert(string $dessert): static
    {
        $this->dessert = $dessert;

        return $this;
    }

    public function getQteDessert(): ?int
    {
        return $this->qteDessert;
    }

    public function setQteDessert(int $qteDessert): static
    {
        $this->qteDessert = $qteDessert;

        return $this;
    }

    


   
}
