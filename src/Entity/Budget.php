<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantMax = null;

    #[ORM\Column(length: 255)]
    private ?string $categorieBudget = null;

    #[ORM\ManyToOne(inversedBy: 'budget')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantMax(): ?int
    {
        return $this->montantMax;
    }

    public function setMontantMax(int $montantMax): static
    {
        $this->montantMax = $montantMax;

        return $this;
    }

    public function getCategorieBudget(): ?string
    {
        return $this->categorieBudget;
    }

    public function setCategorieBudget(string $categorieBudget): static
    {
        $this->categorieBudget = $categorieBudget;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
