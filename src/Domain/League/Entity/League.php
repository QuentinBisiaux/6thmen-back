<?php

namespace App\Domain\League\Entity;

use App\Domain\League\Repository\LeagueRepository;
use App\Domain\Standing\Entity\Standing;
use App\Domain\Team\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: LeagueRepository::class)]
class League
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'leagues')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:sport'
    ])]
    private ?Sport $sport = null;

    #[ORM\OneToMany(mappedBy: 'league', targetEntity: Team::class)]
    #[Groups([
        'read:league'
    ])]
    private Collection $teams;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'League', targetEntity: Standing::class, orphanRemoval: true)]
    private Collection $standings;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->standings = new ArrayCollection();
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

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setLeague($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getLeague() === $this) {
                $team->setLeague(null);
            }
        }

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
            $standing->setLeague($this);
        }

        return $this;
    }

    public function removeStanding(Standing $standing): static
    {
        if ($this->standings->removeElement($standing)) {
            // set the owning side to null (unless already changed)
            if ($standing->getLeague() === $this) {
                $standing->setLeague(null);
            }
        }

        return $this;
    }
}
