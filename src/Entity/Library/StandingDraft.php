<?php

namespace App\Entity\Library;

use App\Repository\Library\StandingDraftRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StandingDraftRepository::class)]
#[UniqueEntity(fields: ['league', 'season', 'team', 'rank'])]
class StandingDraft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'standings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?League $league = null;

    #[ORM\ManyToOne(inversedBy: 'standings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Season $season = null;

    #[ORM\Column]
    #[Groups([
        'read:lottery'
    ])]
    private ?int $victory = null;

    #[ORM\Column]
    #[Groups([
        'read:lottery'
    ])]
    private ?int $loses = null;

    #[ORM\Column]
    #[Groups([
        'read:lottery'
    ])]
    private ?int $rank = null;

    #[ORM\ManyToOne(inversedBy: 'standings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:lottery'
    ])]
    private ?Team $team = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups([
        'read:lottery'
    ])]
    private float $odds;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): static
    {
        $this->league = $league;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getVictory(): ?int
    {
        return $this->victory;
    }

    public function setVictory(int $victory): static
    {
        $this->victory = $victory;

        return $this;
    }

    public function getLoses(): ?int
    {
        return $this->loses;
    }

    public function setLoses(int $loses): static
    {
        $this->loses = $loses;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): static
    {
        $this->rank = $rank;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOdds(): ?float
    {
        return $this->odds;
    }

    public function setOdds(float $odds): static
    {
        $this->odds = $odds;

        return $this;
    }
}
