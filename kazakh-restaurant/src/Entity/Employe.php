<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\EmployeStatus;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(enumType: EmployeStatus::class)]
    private ?EmployeStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'author_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Blog $author_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getStatus(): ?EmployeStatus
    {
        return $this->status;
    }

    public function setStatus(EmployeStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthorId(): ?Blog
    {
        return $this->author_id;
    }

    public function setAuthorId(?Blog $author_id): static
    {
        $this->author_id = $author_id;

        return $this;
    }

   
}
