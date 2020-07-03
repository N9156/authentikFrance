<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
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
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=SiteTouristique::class, mappedBy="comment")
     */
    private $sitestouristiquescomment;

    public function __construct()
    {
        $this->sitestouristiquescomment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection|SiteTouristique[]
     */
    public function getSitestouristiquescomment(): Collection
    {
        return $this->sitestouristiquescomment;
    }

    public function addSitestouristiquescomment(SiteTouristique $sitestouristiquescomment): self
    {
        if (!$this->sitestouristiquescomment->contains($sitestouristiquescomment)) {
            $this->sitestouristiquescomment[] = $sitestouristiquescomment;
            $sitestouristiquescomment->setComment($this);
        }

        return $this;
    }

    public function removeSitestouristiquescomment(SiteTouristique $sitestouristiquescomment): self
    {
        if ($this->sitestouristiquescomment->contains($sitestouristiquescomment)) {
            $this->sitestouristiquescomment->removeElement($sitestouristiquescomment);
            // set the owning side to null (unless already changed)
            if ($sitestouristiquescomment->getComment() === $this) {
                $sitestouristiquescomment->setComment(null);
            }
        }

        return $this;
    }
}
