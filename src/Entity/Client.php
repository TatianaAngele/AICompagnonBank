<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['user:read', 'client:read']],
    denormalizationContext: ['groups' => ['user:write', 'client:write']]
)]
class Client extends Utilisateur
{
    #[ORM\Column(length: 20)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $numCompte = null;

    #[ORM\Column(length: 12)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $cin = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $activite = null;

    /**
     * @var Collection<int, Budget>
     */
    #[ORM\OneToMany(targetEntity: Budget::class, mappedBy: 'client')]
    private Collection $budget;

    /**
     * @var Collection<int, Compte>
     */
    #[ORM\OneToMany(targetEntity: Compte::class, mappedBy: 'client')]
    private Collection $compte;

    public function __construct()
    {
        $this->budget = new ArrayCollection();
        $this->compte = new ArrayCollection();
    }


    public function getNumCompte(): ?string
    {
        return $this->numCompte;
    }

    public function setNumCompte(string $numCompte): static
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): static
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * @return Collection<int, Budget>
     */
    public function getBudget(): Collection
    {
        return $this->budget;
    }

    public function addBudget(Budget $budget): static
    {
        if (!$this->budget->contains($budget)) {
            $this->budget->add($budget);
            $budget->setClient($this);
        }

        return $this;
    }

    public function removeBudget(Budget $budget): static
    {
        if ($this->budget->removeElement($budget)) {
            // set the owning side to null (unless already changed)
            if ($budget->getClient() === $this) {
                $budget->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Compte>
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Compte $compte): static
    {
        if (!$this->compte->contains($compte)) {
            $this->compte->add($compte);
            $compte->setClient($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): static
    {
        if ($this->compte->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getClient() === $this) {
                $compte->setClient(null);
            }
        }

        return $this;
    }
}
