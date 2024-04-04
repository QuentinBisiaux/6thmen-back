<?php

namespace App\Domain\Ranking\StartingFive\Entity;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Ranking\StartingFive\Repository\StartingFiveRepository;
use App\Domain\Team\Franchise;
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
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: UserProfile::class, inversedBy: 'startingFives')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private UserProfile $user;

    #[ORM\ManyToOne(targetEntity: Franchise::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    #[Groups('api:read:starting-five')]
    private Franchise $franchise;

    #[ORM\Column]
    #[Groups('api:read:starting-five')]
    private bool $valid = false;

    #[ORM\Column(type: 'datetime')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'startingFive', targetEntity: StartingFivePlayer::class)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    #[Groups('api:read:starting-five')]
    private Collection $ranking;

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

    public function getFranchise(): Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(Franchise $franchise): self
    {
        $this->franchise = $franchise;
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


}