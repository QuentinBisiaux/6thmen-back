<?php

namespace App\Domain\League\Entity;

use App\Domain\League\Repository\CompetitionRepository;
use App\Domain\Standing\Standing;
use App\Domain\Team\Team;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
#[ORM\UniqueConstraint(name: 'competition_unique', columns: ['name', 'league_id', 'season_id'])]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: CompetitionType::COMPETITION_TYPES, message: "Competition Type is invalid")]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'competitions')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private League $league;

    #[ORM\ManyToOne(inversedBy: 'competitions')]
    #[ORM\JoinColumn]
    private Season $season;

    #[ORM\Column(type: 'integer')]
    #[Assert\GreaterThanOrEqual(0)]
    private int $games = 0;

    #[ORM\Column]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => DateTimeInterface::RFC3339],
    )]
    private \DateTimeImmutable $startAt;

    #[ORM\Column]
    #[Assert\GreaterThan(propertyPath: 'startAt')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private ?\DateTimeImmutable $endAt;

    #[ORM\Column(type: 'datetime')]
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

    /** @var Collection<int, Competition>  */
    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'competitions')]
    private Collection $teams;

    /** @var Collection<int, Tournament>  */
    #[ORM\OneToMany(mappedBy: 'competition', targetEntity: Tournament::class)]
    private Collection $tournaments;

    /** @var Collection<int, Standing>  */
    #[ORM\OneToMany(mappedBy: 'competition', targetEntity: Standing::class)]
    private Collection $standings;

    /** @var Collection<int, Trophy>  */
    #[ORM\OneToMany(mappedBy: 'competition', targetEntity: Trophy::class)]
    private Collection $trophies;

/*    /** @var Collection<int, Forecast>  */
/*    #[ORM\OneToMany(mappedBy: 'competition', targetEntity: Forecast::class)]
    private Collection $forecasts;*/

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
        $this->standings = new ArrayCollection();
        $this->trophies = new ArrayCollection();
        //$this->forecasts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLeague(): League
    {
        return $this->league;
    }

    public function setLeague(League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function getSeason(): Season
    {
        return $this->season;
    }

    public function setSeason(Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getGames(): int
    {
        return $this->games;
    }

    public function setGames(int $games): self
    {
        $this->games = $games;
        return $this;
    }

    public function getStartAt(): \DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): \DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments->add($tournament);
            $tournament->setCompetition($this);
        }

        return $this;
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->addCompetition($this);
        }

        return $this;
    }

    public function getStandings(): Collection
    {
        return $this->standings;
    }

    public function addStanding(Standing $standing): self
    {
        if (!$this->standings->contains($standing)) {
            $this->standings->add($standing);
            $standing->setCompetition($this);
        }

        return $this;
    }

    public function getTrophies(): Collection
    {
        return $this->trophies;
    }

    public function addTrophy(Trophy $trophy): self
    {
        if (!$this->trophies->contains($trophy)) {
            $this->trophies->add($trophy);
            $trophy->setCompetition($this);
        }

        return $this;
    }

/*    public function getForecasts(): Collection
    {
        return $this->trophies;
    }

    public function addForecast(Forecast $forecast): self
    {
        if (!$this->forecasts->contains($forecast)) {
            $this->forecasts->add($forecast);
            $forecast->setCompetition($this);
        }

        return $this;
    }*/

}