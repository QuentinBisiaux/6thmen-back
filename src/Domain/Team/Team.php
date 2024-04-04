<?php

namespace App\Domain\Team;

use App\Domain\League\Entity\Competition;
use App\Domain\Player\Entity\PlayerTeam;
use App\Domain\Standing\Standing;
use App\Domain\Team\Repository\TeamRepository;
use App\Validator\GreaterThanDateOrNull;
use App\Validator\Slug as AssertSlug;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups([
        'read:team'
    ])]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups([
        'read:lottery',
        'read:team',
        'read:player',
        'read:user'
    ])]
    private string $name;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank]
    #[Assert\Length(3)]
    #[Assert\Regex('/^[A-Z]{3}$/')]
    #[Groups([
        'read:lottery'
    ])]
    private string $tricode;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[AssertSlug]
    #[Groups([
        'read:lottery',
        'read:team',
        'read:player',
        'read:user'
    ])]
    private string $slug;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private Franchise $franchise;

    #[ORM\Column(length: 55)]
    #[Assert\NotBlank]
    #[Groups([
        'read:team'
    ])]
    private string $conference;

    //@TODO: Verify if team is in franchise created/ended dates range
    #[ORM\Column(type: 'date')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private \DateTimeInterface $createdIn;

    #[ORM\Column(type: 'date', nullable: true)]
    #[GreaterThanDateOrNull(comparedProperty: 'createdIn')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private ?\DateTimeInterface $endedIn = null;

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

    /** @var Collection<int, Competition> */
    #[ORM\ManyToMany(targetEntity: Competition::class, inversedBy: 'teams')]
    #[ORM\JoinColumn]
    private Collection $competitions;

    /** @var Collection<int, Standing> */
    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Standing::class)]
    private Collection $standings;

    /** @var Collection<int, PlayerTeam> */
    #[ORM\OneToMany(mappedBy: 'team', targetEntity: PlayerTeam::class)]
    private Collection $playerTeams;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
        $this->playerTeams  = new ArrayCollection();
        $this->standings    = new ArrayCollection();
    }

    public function getId(): int
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

    public function getTricode(): string
    {
        return $this->tricode;
    }

    public function setTricode(string $tricode): self
    {
        $this->tricode = $tricode;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFranchise(): Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(Franchise $franchise): self
    {
        $this->franchise = $franchise;

        return $this;
    }

    public function getConference(): string
    {
        return $this->conference;
    }

    public function setConference(string $conference): self
    {
        $this->conference = $conference;

        return $this;
    }

    public function getCreatedIn(): \DateTimeInterface
    {
        return $this->createdIn;
    }

    public function setCreatedIn(\DateTimeInterface $createdIn): self
    {
        $this->createdIn = $createdIn;

        return $this;
    }

    public function getEndedIn(): ?\DateTimeInterface
    {
        return $this->endedIn;
    }

    public function setEndedIn(?\DateTimeInterface $endedIn): self
    {
        $this->endedIn = $endedIn;

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
            $playerTeam->setTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Competition>
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions->add($competition);
            $competition->addTeam($this);
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
            $standing->setTeam($this);
        }

        return $this;
    }

}
