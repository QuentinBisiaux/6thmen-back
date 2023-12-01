<?php

namespace App\Domain\Ranking\StratingFive\Entity;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Ranking\StratingFive\Repository\StartingFiveRepository;
use App\Domain\Team\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Groups('api:read:starting-five')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: UserProfile::class, inversedBy: 'startingFives')]
    #[ORM\JoinColumn(nullable: false)]
    private UserProfile $user;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'startingFives')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('api:read:starting-five')]
    private Team $team;

    #[ORM\OneToMany(mappedBy: 'startingFive', targetEntity: StartingFivePlayer::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups('api:read:starting-five')]
    private Collection $ranking;

    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private bool $valid = false;

    #[ORM\Column]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd-m-Y d:h:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->ranking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): UserProfile
    {
        return $this->user;
    }

    public function setUser(UserProfile $user): self
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

    public function getRanking(): Collection
    {
        return $this->ranking;
    }

    public function addRanking(StartingFivePlayer $startingFivePlayer): self
    {
        if (!$this->ranking->contains($startingFivePlayer)) {
            $this->ranking->add($startingFivePlayer);
            $startingFivePlayer->setStartingFive($this);
        }

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