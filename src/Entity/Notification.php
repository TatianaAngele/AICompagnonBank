<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTime $dateEnvoi = null;

    #[ORM\ManyToOne(inversedBy: 'notification')]
    private ?AIAnalyser $aIAnalyser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTime
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTime $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

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
