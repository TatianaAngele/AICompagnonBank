<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeTransaction = null;

    #[ORM\Column]
    private ?int $montantTransaction = null;

    #[ORM\Column]
    private ?\DateTime $dateTransaction = null;

    #[ORM\Column(length: 255)]
    private ?string $categorieTransaction = null;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    private ?Compte $compte = null;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    private ?AIAnalyser $aIAnalyser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(string $typeTransaction): static
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    public function getMontantTransaction(): ?int
    {
        return $this->montantTransaction;
    }

    public function setMontantTransaction(int $montantTransaction): static
    {
        $this->montantTransaction = $montantTransaction;

        return $this;
    }

    public function getDateTransaction(): ?\DateTime
    {
        return $this->dateTransaction;
    }

    public function setDateTransaction(\DateTime $dateTransaction): static
    {
        $this->dateTransaction = $dateTransaction;

        return $this;
    }

    public function getCategorieTransaction(): ?string
    {
        return $this->categorieTransaction;
    }

    public function setCategorieTransaction(string $categorieTransaction): static
    {
        $this->categorieTransaction = $categorieTransaction;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): static
    {
        $this->compte = $compte;

        return $this;
    }

    public function getAIAnalyser(): ?AIAnalyser
    {
        return $this->aIAnalyser;
    }

    public function setAIAnalyser(?AIAnalyser $aIAnalyser): static
    {
        $this->aIAnalyser = $aIAnalyser;

        return $this;
    }
}
