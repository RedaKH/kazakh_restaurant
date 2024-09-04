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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_reservation = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_personne = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Livreur $livreur_id = null;

    #[ORM\ManyToOne(inversedBy: 'reservation_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

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

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): static
    {
        $this->date_reservation = $date_reservation;

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

    public function getLivreurId(): ?Livreur
    {
        return $this->livreur_id;
    }

    public function setLivreurId(?Livreur $livreur_id): static
    {
        $this->livreur_id = $livreur_id;

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
}
