<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $no = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    /**
     * @var Collection<int, Tailler>
     */
    #[ORM\OneToMany(targetEntity: Tailler::class, mappedBy: 'Devis')]
    private Collection $taillers;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    #[ORM\JoinColumn(referencedColumnName:'id')]
    private ?User $user = null;

    public function __construct()
    {
        $this->taillers = new ArrayCollection();
    }

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): static
    {
        $this->no = $no;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Tailler>
     */
    public function getTaillers(): Collection
    {
        return $this->taillers;
    }

    public function addTailler(Tailler $tailler): static
    {
        if (!$this->taillers->contains($tailler)) {
            $this->taillers->add($tailler);
            $tailler->setDevis($this);
        }

        return $this;
    }

    public function removeTailler(Tailler $tailler): static
    {
        if ($this->taillers->removeElement($tailler)) {
            // set the owning side to null (unless already changed)
            if ($tailler->getDevis() === $this) {
                $tailler->setDevis(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): static
    {
        $this->Client = $Client;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
