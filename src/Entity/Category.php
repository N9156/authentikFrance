<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=SiteTouristique::class, mappedBy="category")
     */
    private $sitestouristiques;

    public function __construct()
    {
        $this->sitestouristiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $sitestouristique->setCategory($this);
        }

        return $this;
    }

    public function removeSitestouristique(SiteTouristique $sitestouristique): self
    {
        if ($this->sitestouristiques->contains($sitestouristique)) {
            $this->sitestouristiques->removeElement($sitestouristique);
            // set the owning side to null (unless already changed)
            if ($sitestouristique->getCategory() === $this) {
                $sitestouristique->setCategory(null);
            }
        }

        return $this;
    }
}
