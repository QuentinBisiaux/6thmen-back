<?php

namespace App\Domain\Ranking\StartingFive\Entity;

use App\Domain\Player\Entity\Player;
use App\Domain\Player\Entity\Position;
use App\Domain\Ranking\StartingFive\Repository\StartingFivePlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: StartingFivePlayerRepository::class)]
class StartingFivePlayer
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ranking')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private StartingFive $startingFive;

    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private int $position;

    #[ORM\ManyToOne(inversedBy: 'startingFive')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('api:read:starting-five')]
    private ?Player $player;

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

    public function getStartingFive(): StartingFive
    {
        return $this->startingFive;
    }

    public function setStartingFive(StartingFive $startingFive): self
    {
        $this->startingFive = $startingFive;
        return $this;
    }

    public function getPosition(): string
    {
        return Position::BASE_POSITION_BY_NUMBER[$this->position];
    }

    public function setPosition(string $position): self
    {
        $this->position = Position::NUMBER_POSITION_BY_POSITION[$position];
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