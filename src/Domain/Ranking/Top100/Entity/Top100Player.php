<?php

namespace App\Domain\Ranking\Top100\Entity;

use App\Domain\Player\Entity\Player;
use App\Domain\Ranking\Top100\Repository\Top100PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: Top100PlayerRepository::class)]
class Top100Player
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups('read:top-100')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ranking')]
    #[ORM\JoinColumn(nullable: false)]
    private Top100 $top100;

    #[ORM\Column(nullable: false)]
    #[Groups('read:top-100')]
    private int $rank;

    #[ORM\ManyToOne(inversedBy: 'top100')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('read:top-100')]
    private ?Player $player = null;

    #[ORM\Column(type: 'datetime')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTop100(): Top100
    {
        return $this->top100;
    }

    public function setTop100(Top100 $top100): self
    {
        $this->top100 = $top100;
        return $this;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;
        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}