<?php

namespace App\Domain\League\Entity;

use App\Domain\League\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'competition', targetEntity: Tournament::class)]
    private Collection $tournaments;

    #[ORM\ManyToOne(inversedBy: 'competitions')]
    #[ORM\JoinColumn(nullable: false)]
    private League $league;

    #[ORM\ManyToOne(inversedBy: 'competitions')]
    #[ORM\JoinColumn(nullable: false)]
    private Season $season;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $startAt = null;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endAt = null;

    public function __construct()
    {
        $this->tournaments = new ArrayCollection();
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

    public function getLeague(): League
    {
        return $this->league;
    }

    public function setLeague(League $league): void
    {
        $this->league = $league;
    }

    public function getSeason(): Season
    {
        return $this->season;
    }

    public function setSeason(Season $season): void
    {
        $this->season = $season;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setCreatedAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

}