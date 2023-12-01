<?php

namespace App\Domain\League\Entity;

use App\Domain\Forecast\RegularSeason\Entity\ForecastRegularSeason;
use App\Domain\League\Repository\SeasonRepository;
use App\Domain\Player\Entity\PlayerTeam;
use App\Domain\Standing\Entity\Standing;
use App\Domain\Standing\Entity\StandingDraft;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 10)]
    #[Groups([
        'read:player',
    ])]
    private ?string $year = null;

    #[ORM\Column]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: PlayerTeam::class)]
    private Collection $playerTeams;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: Standing::class)]
    private Collection $standings;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: StandingDraft::class)]
    private Collection $standingsDraft;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: ForecastRegularSeason::class)]
    private Collection $forecastRegularSeason;

    public function __construct()
    {
        $this->playerTeams = new ArrayCollection();
        $this->standings = new ArrayCollection();
        $this->standingsDraft = new ArrayCollection();
        $this->forecastRegularSeason = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
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

    /**
     * @return Collection<int, PlayerTeam>
     */
    public function getPlayerTeams(): Collection
    {
        return $this->playerTeams;
    }

    public function addPlayerTeam(PlayerTeam $playerTeam): self
    {
        if (!$this->playerTeams->contains($playerTeam)) {
            $this->playerTeams->add($playerTeam);
            $playerTeam->setSeason($this);
        }

        return $this;
    }

    public function removePlayerTeam(PlayerTeam $playerTeam): self
    {
        if ($this->playerTeams->removeElement($playerTeam)) {
            // set the owning side to null (unless already changed)
            if ($playerTeam->getSeason() === $this) {
                $playerTeam->setSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Standing>
     */
    public function getStandings(): Collection
    {
        return $this->standings;
    }

    public function addStanding(Standing $standing): static
    {
        if (!$this->standings->contains($standing)) {
            $this->standings->add($standing);
            $standing->setSeason($this);
        }

        return $this;
    }

    public function removeStanding(Standing $standing): static
    {
        if ($this->standings->removeElement($standing)) {
            // set the owning side to null (unless already changed)
            if ($standing->getSeason() === $this) {
                $standing->setSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StandingDraft>
     */
    public function getStandingDrafts(): Collection
    {
        return $this->standingsDraft;
    }

    public function addStandingDraft(StandingDraft $standingDraft): static
    {
        if (!$this->standingsDraft->contains($standingDraft)) {
            $this->standingsDraft->add($standingDraft);
            $standingDraft->setSeason($this);
        }

        return $this;
    }

    public function removeStandingDraft(StandingDraft $standingDraft): static
    {
        if ($this->standingsDraft->removeElement($standingDraft)) {
            // set the owning side to null (unless already changed)
            if ($standingDraft->getSeason() === $this) {
                $standingDraft->setSeason(null);
            }
        }

        return $this;
    }

    public function getForecastRegularSeason(): Collection
    {
        return $this->forecastRegularSeason;
    }

    public function addForecastRegularSeason(ForecastRegularSeason $forecastRegularSeason): self
    {
        if (!$this->forecastRegularSeason->contains($forecastRegularSeason)) {
            $this->forecastRegularSeason->add($forecastRegularSeason);
            $forecastRegularSeason->setSeason($this);
        }

        return $this;
    }
}
