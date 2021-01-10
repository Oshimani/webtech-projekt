<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfDeath;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $imgUrl;

    /**
     * @ORM\OneToMany(targetEntity=Poem::class, mappedBy="author", cascade={"persist"})
     */
    private $poems;

    public function __construct()
    {
        $this->poems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getDateOfDeath(): ?\DateTimeInterface
    {
        return $this->dateOfDeath;
    }

    public function setDateOfDeath(?\DateTimeInterface $dateOfDeath): self
    {
        $this->dateOfDeath = $dateOfDeath;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * @return Collection|Poem[]
     */
    public function getPoems(): Collection
    {
        return $this->poems;
    }

    public function addPoem(Poem $poem): self
    {
        if (!$this->poems->contains($poem)) {
            $this->poems[] = $poem;
            $poem->setAuthor($this);
        }

        return $this;
    }

    public function removePoem(Poem $poem): self
    {
        if ($this->poems->removeElement($poem)) {
            // set the owning side to null (unless already changed)
            if ($poem->getAuthor() === $this) {
                $poem->setAuthor(null);
            }
        }

        return $this;
    }

    // required for rendereing author name in dropdown under /poem/new
    public function __toString(): string
    {
        return $this->name;
    }
}
