<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 500)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, Employe>
     */
    #[ORM\OneToMany(targetEntity: Employe::class, mappedBy: 'author_id')]
    private Collection $author_id;

    public function __construct()
    {
        $this->author_id = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getAuthorId(): Collection
    {
        return $this->author_id;
    }

    public function addAuthorId(Employe $authorId): static
    {
        if (!$this->author_id->contains($authorId)) {
            $this->author_id->add($authorId);
            $authorId->setAuthorId($this);
        }

        return $this;
    }

    public function removeAuthorId(Employe $authorId): static
    {
        if ($this->author_id->removeElement($authorId)) {
            // set the owning side to null (unless already changed)
            if ($authorId->getAuthorId() === $this) {
                $authorId->setAuthorId(null);
            }
        }

        return $this;
    }

  
}
