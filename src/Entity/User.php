<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields = {"mail"},
 * message="Un compte est déjà existant à cette adresse Email !!"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userlastname;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Veuillez renseigner un email valide")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Vootre mot de passe doit contenir 8 caractères minimum")
     * @Assert\EqualTo(propertyPath="confirm_password", message="Les mots de passe ne correspondent pas")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne correspondent pas")
     */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="users", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=SiteTouristique::class, mappedBy="user")
     */
    private $sitestouristiques;

//     /**
//      * @ORM\Column(type="json")
//      */
//     private $roles = [];

  
    

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->sitestouristiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserlastname(): ?string
    {
        return $this->userlastname;
    }

    public function setUserlastname(string $userlastname): self
    {
        $this->userlastname = $userlastname;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getRoles()
    {
        //return ['ROLE_USER'];
        return $this->roles;
        //retourne les roles de la bdd
    }

    

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        
    }

    public function eraseCredentials()
    {
        
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUsers($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SiteTouristique[]
     */
    public function getSitestouristiques(): Collection
    {
        return $this->sitestouristiques;
    }

    public function addSitestouristique(SiteTouristique $sitestouristique): self
    {
        if (!$this->sitestouristiques->contains($sitestouristique)) {
            $this->sitestouristiques[] = $sitestouristique;
            $sitestouristique->setUser($this);
        }

        return $this;
    }

    public function removeSitestouristique(SiteTouristique $sitestouristique): self
    {
        if ($this->sitestouristiques->contains($sitestouristique)) {
            $this->sitestouristiques->removeElement($sitestouristique);
            // set the owning side to null (unless already changed)
            if ($sitestouristique->getUser() === $this) {
                $sitestouristique->setUser(null);
            }
        }

        return $this;
    }
    /*
    public function __toString()
    {
        return $this->username;

    }*/    

}
