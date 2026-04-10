<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\BudgetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: BudgetRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['budget:read', 'client:read']],
    denormalizationContext: ['groups' => ['budget:write', 'client:write']]
)]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['budget:read', 'client:write'])]
    private ?int $montantMax = null;

    #[ORM\Column(length: 255)]
    #[Groups(['budget:read', 'client:write'])]
    private ?string $categorieBudget = null;

    #[ORM\ManyToOne(inversedBy: 'budget')]
    #[Groups(['budget:read', 'client:write'])]
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
