<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Repository\TransactionRepository;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(),
        new Post()
    ],
    normalizationContext: ['groups' => ['transaction:read', 'compte:read', 'client:read', 'user:read']],
    denormalizationContext: ['groups' => ['transaction:write']]
)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['transaction:read', 'transaction:write'])]
    private ?string $typeTransaction = null;

    #[ORM\Column]
    #[Groups(['transaction:read',  'transaction:write'])]
    private ?int $montantTransaction = null;

    #[ORM\Column]
    #[Groups(['transaction:read'])]
    private ?\DateTime $dateTransaction = null;

    #[ORM\Column(length: 255)]
    #[Groups(['transaction:read',  'transaction:write'])]
    private ?string $categorieTransaction = null;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    #[Groups(['compte:read', 'client:read', 'user:read', 'transaction:write'])]
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

    #[ORM\PrePersist]
    public function setDateTransaction(): static
    {
        if ($this->dateTransaction == null) {
            $this->dateTransaction = new \DateTime();
        }

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

    #[ORM\PrePersist]
    public function updateCompteSolde(): void
    {
        // 🔒 Vérification des données obligatoires
        if (!$this->compte) {
            throw new BadRequestHttpException("Compte obligatoire");
        }

        if (!$this->montantTransaction || $this->montantTransaction <= 0) {
            throw new BadRequestHttpException("Montant invalide");
        }

        if (!$this->typeTransaction) {
            throw new BadRequestHttpException("Type de transaction obligatoire");
        }

        $montant = $this->montantTransaction;
        $type = strtolower($this->typeTransaction); // sécurité (maj/min)

        $soldeActuel = $this->compte->getSolde();

        // 💸 Cas retrait / transfert
        if ($type === "retrait" || $type === "transfert") {

            if ($soldeActuel < $montant) {
                throw new BadRequestHttpException("Solde insuffisant");
            }

            $this->compte->setSolde($soldeActuel - $montant);
            return;
        }

        // 💰 Cas dépôt (ou autre)
        if ($type === "depot") {
            $this->compte->setSolde($soldeActuel + $montant);
            return;
        }

        // ❌ Type inconnu
        throw new BadRequestHttpException("Type de transaction invalide");
    }
}
