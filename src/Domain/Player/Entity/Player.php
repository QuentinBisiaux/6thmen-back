<?php

namespace App\Domain\Player\Entity;

use App\Domain\Forecast\Trophy\Entity\TrophyForecast;
use App\Domain\Player\Repository\PlayerRepository;
use App\Domain\Ranking\StartingFive\Entity\StartingFivePlayer;
use App\Domain\Ranking\Top100\Entity\Top100Player;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups([
        'read:player',
        'api:read:forecast-trophies'
    ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups([
        'read:player',
        'api:read:forecast-trophies'
    ])]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Groups(['read:player:details'])]
    private ?string $birthPlace = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private int $hypeScore = 0;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\LessThan('today')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    #[Groups(['read:player:details'])]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\LessThan('today')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Assert\GreaterThan(propertyPath: 'createdAt')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: PlayerTeam::class)]
    private Collection $playerTeams;

    #[ORM\OneToMany(mappedBy: 'players', targetEntity: Top100Player::class)]
    private Collection $top100;

    #[ORM\OneToMany(mappedBy: 'players', targetEntity: StartingFivePlayer::class)]
    private Collection $startingFives;

    #[ORM\OneToMany(mappedBy: 'players', targetEntity: TrophyForecast::class)]
    private Collection $trophiesForecast;

    public function __construct()
    {
        $this->playerTeams = new ArrayCollection();
        $this->top100 = new ArrayCollection();
        $this->startingFives = new ArrayCollection();
        $this->trophiesForecast = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthPlace(): string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(string $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthDay): self
    {
        $this->birthday = $birthDay;

        return $this;
    }

    public function getHypeScore(): int
    {
        return $this->hypeScore;
    }

    public function setHypeScore(int $hypeScore): self
    {
        $this->hypeScore = $hypeScore;

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

    /** @return Collection<int, PlayerTeam> */
    public function getTeams(): Collection
    {
        return $this->playerTeams;
    }

    public function addPlayerTeam(PlayerTeam $playerTeam): self
    {
        if (!$this->playerTeams->contains($playerTeam)) {
            $this->playerTeams->add($playerTeam);
            $playerTeam->setPlayer($this);
        }

        return $this;
    }

    public function getTop100(): Collection
    {
        return $this->top100;
    }

    public function addToTop100(Top100Player $top100Player): self
    {
        if (!$this->top100->contains($top100Player)) {
            $this->top100->add($top100Player);
            $top100Player->setPlayer($this);
        }

        return $this;
    }

    public function removeFromTop100(Top100Player $top100Player): self
    {
        if ($this->top100->removeElement($top100Player)) {
            // set the owning side to null (unless already changed)
            if ($top100Player->getPlayer() === $this) {
                $top100Player->setPlayer(null);
            }
        }

        return $this;
    }

    public function getStartingFives(): Collection
    {
        return $this->startingFives;
    }

    public function addToStartingFive(StartingFivePlayer $startingFivePlayer): self
    {
        if (!$this->startingFives->contains($startingFivePlayer)) {
            $this->startingFives->add($startingFivePlayer);
            $startingFivePlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeFromStartingFive(StartingFivePlayer $startingFivePlayer): self
    {
        if ($this->top100->removeElement($startingFivePlayer)) {
            if ($startingFivePlayer->getPlayer() === $this) {
                $startingFivePlayer->setPlayer(null);
            }
        }

        return $this;
    }

    public function getTrophiesForecast(): Collection
    {
        return $this->trophiesForecast;
    }

    public function addToTrophyForecast(TrophyForecast $trophyForecast): self
    {
        if (!$this->trophiesForecast->contains($trophyForecast)) {
            $this->trophiesForecast->add($trophyForecast);
            $trophyForecast->setPlayer($this);
        }

        return $this;
    }

}
