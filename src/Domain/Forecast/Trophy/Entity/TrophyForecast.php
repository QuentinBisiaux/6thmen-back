<?php

namespace App\Domain\Forecast\Trophy\Entity;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Forecast\Trophy\Repository\TrophyForecastRepository;
use App\Domain\Player\Entity\Player;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: TrophyForecastRepository::class)]
class TrophyForecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: '$trophiesForecast')]
    #[ORM\JoinColumn(nullable: false)]
    private UserProfile $userProfile;

    #[ORM\ManyToOne(inversedBy: 'trophy')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('api:read:forecast-trophies')]
    private Trophy $trophy;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Groups('api:read:forecast-trophies')]
    private int $rank;

    #[ORM\ManyToOne(inversedBy: 'top100')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('api:read:forecast-trophies')]
    private ?Player $player = null;

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

    public function getUserProfile(): UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile): void
    {
        $this->userProfile = $userProfile;
    }

    public function getTrophy(): Trophy
    {
        return $this->trophy;
    }

    public function setTrophy(Trophy $trophy): void
    {
        $this->trophy = $trophy;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): void
    {
        $this->player = $player;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}