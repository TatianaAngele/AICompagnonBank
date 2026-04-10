<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends Utilisateur
{
    #[ORM\Column(length: 10)]
    private ?string $matricule = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?AIAnalyser $aianalyser = null;

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getAianalyser(): ?AIAnalyser
    {
        return $this->aianalyser;
    }

    public function setAianalyser(?AIAnalyser $aianalyser): static
    {
        $this->aianalyser = $aianalyser;

        return $this;
    }
}
