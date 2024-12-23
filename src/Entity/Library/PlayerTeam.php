<?php

namespace App\Entity\Library;

use App\Repository\Library\PlayerTeamsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlayerTeamsRepository::class)]
class PlayerTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playerTeams')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:player',
    ])]
    private ?Season $season = null;

    #[ORM\ManyToOne(inversedBy: 'playerTeams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $player = null;

    #[ORM\ManyToOne(inversedBy: 'playerTeams')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:player',
    ])]
    private ?Team $team = null;

    #[Groups([
        'read:player',
    ])]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $position = null;

    #[Groups([
        'read:player',
    ])]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $jerseyNumber = null;

    #[ORM\Column]
    #[Groups([
        'read:player',
    ])]
    private ?bool $rookieYear = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

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

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getJerseyNumber(): ?string
    {
        return $this->jerseyNumber;
    }

    public function setJerseyNumber(string $jerseyNumber): self
    {
        $this->jerseyNumber = $jerseyNumber;

        return $this;
    }

    public function isRookieYear(): ?bool
    {
        return $this->rookieYear;
    }

    public function setRookieYear(bool $rookieYear): self
    {
        $this->rookieYear = $rookieYear;

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
}
