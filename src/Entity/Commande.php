<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_At = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'commandes')]
    private Collection $p;

    public function __construct()
    {
        $this->p = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeImmutable $created_At): self
    {
        $this->created_At = $created_At;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getP(): Collection
    {
        return $this->p;
    }

    public function addP(Product $p): self
    {
        if (!$this->p->contains($p)) {
            $this->p->add($p);
        }

        return $this;
    }

    public function removeP(Product $p): self
    {
        $this->p->removeElement($p);

        return $this;
    }

    public function __toString()
    {
      return $this->id;  
    }
}
