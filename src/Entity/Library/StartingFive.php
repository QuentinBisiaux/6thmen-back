<?php

namespace App\Entity\Library;

use App\Repository\Library\StartingFiveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: StartingFiveRepository::class)]
class StartingFive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'startingFives')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'startingFives')]
    #[ORM\JoinColumn(nullable: false)]
    private Team $team;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'allTimePointGuard')]
    #[ORM\JoinColumn(nullable: false)]
    private Player $pointGuard;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'allTimeGuard')]
    #[ORM\JoinColumn(nullable: false)]
    private Player $guard;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'allTimeForward')]
    #[ORM\JoinColumn(nullable: false)]
    private Player $forward;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'allTimeSmallForward')]
    #[ORM\JoinColumn(nullable: false)]
    private Player $smallForward;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'allTimeCenter')]
    #[ORM\JoinColumn(nullable: false)]
    private Player $center;

    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private bool $valid = false;

    #[ORM\Column]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[Groups('api:read:starting-five')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[Groups('api:read:starting-five')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
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

    public function getPointGuard(): Player
    {
        return $this->pointGuard;
    }

    public function setPointGuard(Player $pointGuard): self
    {
        $this->pointGuard = $pointGuard;
        return $this;
    }

    public function getGuard(): Player
    {
        return $this->guard;
    }

    public function setGuard(Player $guard): self
    {
        $this->guard = $guard;
        return $this;
    }

    public function getForward(): Player
    {
        return $this->forward;
    }

    public function setForward(Player $forward): self
    {
        $this->forward = $forward;
        return $this;
    }

    public function getSmallForward(): Player
    {
        return $this->smallForward;
    }

    public function setSmallForward(Player $smallForward): self
    {
        $this->smallForward = $smallForward;
        return $this;
    }

    public function getCenter(): Player
    {
        return $this->center;
    }

    public function setCenter(Player $center): self
    {
        $this->center = $center;
        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;
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