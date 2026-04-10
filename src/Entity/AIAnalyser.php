<?php

namespace App\Entity;

use App\Repository\AIAnalyserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AIAnalyserRepository::class)]
class AIAnalyser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modeleAnalyse = null;

    #[ORM\Column(length: 255)]
    private ?string $modeleRecommendation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $seuilAnomalie = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'aIAnalyser')]
    private Collection $transaction;

    /**
     * @var Collection<int, Notification>
     */
    #[ORM\OneToMany(targetEntity: Notification::class, mappedBy: 'aIAnalyser')]
    private Collection $notification;

    public function __construct()
    {
        $this->transaction = new ArrayCollection();
        $this->notification = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeleAnalyse(): ?string
    {
        return $this->modeleAnalyse;
    }

    public function setModeleAnalyse(string $modeleAnalyse): static
    {
        $this->modeleAnalyse = $modeleAnalyse;

        return $this;
    }

    public function getModeleRecommendation(): ?string
    {
        return $this->modeleRecommendation;
    }

    public function setModeleRecommendation(string $modeleRecommendation): static
    {
        $this->modeleRecommendation = $modeleRecommendation;

        return $this;
    }

    public function getSeuilAnomalie(): ?string
    {
        return $this->seuilAnomalie;
    }

    public function setSeuilAnomalie(string $seuilAnomalie): static
    {
        $this->seuilAnomalie = $seuilAnomalie;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransaction(): Collection
    {
        return $this->transaction;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transaction->contains($transaction)) {
            $this->transaction->add($transaction);
            $transaction->setAIAnalyser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transaction->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getAIAnalyser() === $this) {
                $transaction->setAIAnalyser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotification(): Collection
    {
        return $this->notification;
    }

    public function addNotification(Notification $notification): static
    {
        if (!$this->notification->contains($notification)) {
            $this->notification->add($notification);
            $notification->setAIAnalyser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): static
    {
        if ($this->notification->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getAIAnalyser() === $this) {
                $notification->setAIAnalyser(null);
            }
        }

        return $this;
    }
}
