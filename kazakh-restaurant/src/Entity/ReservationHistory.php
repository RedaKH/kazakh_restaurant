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
}
