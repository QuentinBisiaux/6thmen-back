<?php

namespace App\Domain\Forecast\Trophy\Entity;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Forecast\Trophy\Repository\TrophyForecastRepository;
use App\Domain\League\Entity\Trophy;
use App\Domain\Player\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: TrophyForecastRepository::class)]
class TrophyForecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: '$trophiesForecast')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private UserProfile $userProfile;

    #[ORM\ManyToOne(inversedBy: 'trophy')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    #[Groups('api:read:forecast-trophies')]
    private Trophy $trophy;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Groups('api:read:forecast-trophies')]
    private int $rank;

    #[ORM\ManyToOne(inversedBy: 'top100')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('api:read:forecast-trophies')]
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

    public function getUserProfile(): UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile): self
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    public function getTrophy(): Trophy
    {
        return $this->trophy;
    }

    public function setTrophy(Trophy $trophy): self
    {
        $this->trophy = $trophy;

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