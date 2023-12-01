<?php

namespace App\Domain\Ranking\StratingFive\Entity;

use App\Domain\Player\Entity\Player;
use App\Domain\Player\Entity\Position;
use App\Domain\Ranking\StratingFive\Repository\StartingFivePlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: StartingFivePlayerRepository::class)]
class StartingFivePlayer
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ranking')]
    #[ORM\JoinColumn(nullable: false)]
    private StartingFive $startingFive;

    #[ORM\Column(nullable: false)]
    #[Groups('api:read:starting-five')]
    private int $position;

    #[ORM\ManyToOne(inversedBy: 'startingFive')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('api:read:starting-five')]
    private ?Player $player;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}