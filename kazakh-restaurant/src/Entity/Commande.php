<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\CommandeStatus;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'commande')]
    private Collection $reservation_id;



    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: CommandeStatus::class)]
    private array $commandeStatus = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(length: 255)]
    private ?string $plat = null;


    public function __construct()
    {
        $this->reservation_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservationId(): Collection
    {
        return $this->reservation_id;
    }

    public function addReservationId(Reservation $reservationId): static
    {
        if (!$this->reservation_id->contains($reservationId)) {
            $this->reservation_id->add($reservationId);
            $reservationId->setCommande($this);
        }

        return $this;
    }

    public function removeReservationId(Reservation $reservationId): static
    {
        if ($this->reservation_id->removeElement($reservationId)) {
            // set the owning side to null (unless already changed)
            if ($reservationId->getCommande() === $this) {
                $reservationId->setCommande(null);
            }
        }

        return $this;
    }

   

   

    /**
     * @return CommandeStatus[]
     */
    public function getCommandeStatus(): array
    {
        return $this->commandeStatus;
    }

    public function setCommandeStatus(array $commandeStatus): static
    {
        $this->commandeStatus = $commandeStatus;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

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

 
}
