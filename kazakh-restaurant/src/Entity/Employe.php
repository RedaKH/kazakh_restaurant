<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe implements UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;
    #[ORM\Column(type: 'json')]
    private array $roles = []; // Stockage des rôles sous forme de chaînes

    #[ORM\Column] // Ajoute cette ligne pour le mot de passe
    private ?string $password = null;

    /**
     * @var Collection<int, Blog>
     */
    #[ORM\OneToMany(targetEntity: Blog::class, mappedBy: 'Author')]
    private Collection $blogs;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'employe')]
    private Collection $reservations;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }




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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

  

  

   

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }


    public function getSalt(): ?string{
        return null;
    }

    public function getRoles(): array
{
    // Convertir les rôles en chaînes de caractères
    $roles = array_map(function ($role) {
        if ($role instanceof Role) {
            return $role->value;
        }

        // Si le rôle est déjà une chaîne de caractères, le retourner tel quel
        return $role;
    }, $this->roles);

    // Ajouter un rôle par défaut s'il n'y a pas de rôle spécifique
    if (empty($roles)) {
        $roles[] = Role::EMPLOYE->value;
    }

    return array_unique($roles);
}


    public function setRoles(array $roles): static
    {
        // Convertir chaque chaîne de caractères en instance de l'énumération Role
        $this->roles = array_map(function($role) {
            if ($role instanceof Role) {
                return $role;
            }
            return Role::from($role);
        }, $roles);

        return $this;
    }
    
    public function eraseCredentials(): void
    {

    }
    public function getUserIdentifier(): string
    {
        // Retourne l'email comme identifiant unique
        return $this->email;
    }

    /**
     * @return Collection<int, Blog>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blog $blog): static
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs->add($blog);
            $blog->setAuthor($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): static
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getAuthor() === $this) {
                $blog->setAuthor(null);
            }
        }

        return $this;
    }

   


    

   
}
