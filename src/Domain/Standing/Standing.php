<?php

namespace App\Domain\Standing;

use App\Domain\League\Entity\Competition;
use App\Domain\Team\Team;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StandingRepository::class)]
#[ORM\UniqueConstraint(name: 'standing_unique', columns: ['team_id', 'competition_id'])]
class Standing
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    #[Assert\Type('integer')]
    #[Groups([
        'read:lottery'
    ])]
    private ?int $rank = null;

    #[ORM\ManyToOne(inversedBy: 'standings')]
    #[ORM\JoinColumn]
    #[Groups([
        'read:lottery'
    ])]
    private Team $team;

    #[ORM\ManyToOne(inversedBy: 'standings')]
    #[ORM\JoinColumn]
    private Competition $competition;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    #[Assert\Type('integer')]
    #[Groups([
        'read:lottery'
    ])]
    private int $victories = 0;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    #[Assert\Type('integer')]
    #[Groups([
        'read:lottery'
    ])]
    private int $loses = 0;

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

    #[Groups([
        'read:lottery'
    ])]
    private ?float $odd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getCompetition(): Competition
    {
        return $this->competition;
    }

    public function setCompetition(Competition $competition): self
    {
        $this->competition = $competition;
        if (!$this->competition->getStandings()->contains($this)) {
            $this->competition->addStanding($this);
        }
        return $this;
    }

    public function getVictories(): int
    {
        return $this->victories;
    }

    public function setVictories(int $victories): self
    {
        $this->victories = $victories;

        return $this;
    }

    public function getLoses(): ?int
    {
        return $this->loses;
    }

    public function setLoses(int $loses): self
    {
        $this->loses = $loses;

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

    public function getOdd(): ?float
    {
        return $this->odd;
    }

    public function setOdd(?float $odd): self
    {
        $this->odd = $odd;

        return $this;
    }

}
