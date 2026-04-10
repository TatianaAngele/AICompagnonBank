<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(),
        new Post(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['notification:read', 'aianalyser:read']],
    denormalizationContext: ['groups' => ['notification:write']]
)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['notification:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['notification:read', 'notification:write'])]
    private ?string $message = null;

    #[ORM\Column]
    #[Groups(['notification:read'])]
    private ?\DateTime $dateEnvoi = null;

    #[ORM\ManyToOne(inversedBy: 'notification')]
    #[Groups(['notification:read', 'aianalyser:read', 'notification:write'])]
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

    #[ORM\PrePersist]
    public function setDateEnvoi(): static
    {
        if ($this->dateEnvoi == null) {
            $this->dateEnvoi = new \DateTime();
        }

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
