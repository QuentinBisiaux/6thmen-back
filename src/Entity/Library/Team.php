<?php

namespace App\Entity\Library;

use App\Repository\Library\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:team'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:lottery',
        'read:team',
        'read:player'
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:lottery'
    ])]
    private ?string $tricode = null;

    #[Groups([
        'read:lottery',
        'read:team'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'sisterTeams')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Team $sisterTeam = null;

    #[ORM\OneToMany(mappedBy: 'sisterTeam', targetEntity: Team::class)]
    private Collection $sisterTeams;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?League $league = null;

    #[ManyToMany(targetEntity: UserProfile::class, mappedBy: 'favoriteTeams')]
    private Collection $fans;
    
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdIn = null;

    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endedIn = null;
    
    #[ORM\OneToMany(mappedBy: 'team', targetEntity: PlayerTeam::class)]
    private Collection $playerTeams;

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

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Standing::class)]
    private Collection $standings;

    public function __construct()
    {
        $this->playerTeams  = new ArrayCollection();
        $this->sisterTeams  = new ArrayCollection();
        $this->standings    = new ArrayCollection();
        $this->fans         = new ArrayCollection();
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

    public function getTricode(): ?string
    {
        return $this->tricode;
    }

    public function setTricode(string $tricode): self
    {
        $this->tricode = $tricode;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getCreatedIn(): ?\DateTimeInterface
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

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function getFans(): Collection
    {
        return $this->fans;
    }

    public function addFan(UserProfile $userProfile): self
    {
        if (!$this->fans->contains($userProfile)) {
            $this->fans[] = $userProfile;
        }

        return $this;
    }

    public function removeFan(UserProfile $userProfile): self
    {
        $this->fans->removeElement($userProfile);

        return $this;
    }

    public function getSisterTeam(): ?Team
    {
        return $this->sisterTeam;
    }

    public function setSisterTeam(?Team $sisterTeam): void
    {
        $this->sisterTeam = $sisterTeam;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getSisterTeams(): Collection
    {
        return $this->sisterTeams;
    }

    public function addSisterTeam(Team $sisterTeam): void
    {
        if (!$this->sisterTeams->contains($sisterTeam)) {
            $this->sisterTeams->add($sisterTeam);
            $sisterTeam->setSisterTeam($this);
        }
    }

    public function removeSisterTeam(Team $sisterTeam): void
    {
        if ($this->sisterTeams->removeElement($sisterTeam)) {
            $sisterTeam->setSisterTeam(null);
        }
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

    public function removePlayerTeam(PlayerTeam $playerTeam): self
    {
        if ($this->playerTeams->removeElement($playerTeam)) {
            // set the owning side to null (unless already changed)
            if ($playerTeam->getTeam() === $this) {
                $playerTeam->setTeam(null);
            }
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

    public function removeStanding(Standing $standing): static
    {
        if ($this->standings->removeElement($standing)) {
            // set the owning side to null (unless already changed)
            if ($standing->getTeam() === $this) {
                $standing->setTeam(null);
            }
        }

        return $this;
    }

}
