<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\ReservationType;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: ReservationType::class)]
    private ?ReservationType $ReservationType = null;

  


    #[ORM\Column(nullable: true)]
    private ?int $nombre_personne = null;

 

    #[ORM\ManyToOne(inversedBy: 'reservation_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'reserver')]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    private ?string $plat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateReservation = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Employe $livreur = null;

    #[ORM\Column(length: 255)]
    private ?string $entree = null;

    #[ORM\Column]
    private ?int $QteEntree = null;

    #[ORM\Column]
    private ?int $QtePlat = null;

    #[ORM\Column(length: 255)]
    private ?string $Boisson = null;

    #[ORM\Column]
    private ?int $QteBoisson = null;

    #[ORM\Column(length: 255)]
    private ?string $dessert = null;

    #[ORM\Column]
    private ?int $qteDessert = null;
    
   







    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationType(): ?ReservationType
    {
        return $this->ReservationType;
    }

    public function setReservationType(ReservationType $ReservationType): static
    {
        $this->ReservationType = $ReservationType;

        return $this;
    }



    public function getNombrePersonne(): ?int
    {
        return $this->nombre_personne;
    }

    public function setNombrePersonne(?int $nombre_personne): static
    {
        $this->nombre_personne = $nombre_personne;

        return $this;
    }

  
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->DateReservation;
    }

    public function setDateReservation(\DateTimeInterface $DateReservation): static
    {
        $this->DateReservation = $DateReservation;

        return $this;
    }

    public function getLivreur(): ?Employe
    {
        return $this->livreur;
    }

    public function setLivreur(?Employe $livreur): static
    {
        $this->livreur = $livreur;

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
