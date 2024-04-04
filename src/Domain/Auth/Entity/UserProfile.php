<?php

namespace App\Domain\Auth\Entity;

use App\Domain\Auth\Repository\UserProfileRepository;
use App\Domain\Forecast\Trophy\Entity\TrophyForecast;
use App\Domain\Ranking\StartingFive\Entity\StartingFive;
use App\Domain\Ranking\Top100\Entity\Top100;
use App\Domain\Team\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
#[ORM\Table(name: '`user_data`')]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:user')]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups('read:user')]
    private ?string $profileImageUrl = null;

    #[ORM\Column(nullable: true)]
    #[Groups('read:user')]
    private ?string $location = null;

    #[ORM\OneToOne(inversedBy: 'userProfile', targetEntity: Top100::class)]
    private ?Top100 $top100;

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

    #[ORM\OneToMany(mappedBy: 'userProfile', targetEntity: TrophyForecast::class, orphanRemoval: true)]
    #[Groups('read:user')]
    #[ORM\OrderBy(['id' => 'ASC'])]
    private Collection $trophiesForecast;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: StartingFive::class, orphanRemoval: true)]
    #[Groups('read:user')]
    private Collection $startingFive;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'fans')]
    #[JoinTable(name: 'user_favorite_teams')]
    #[Groups('read:user')]
    private Collection $favoriteTeams;

    public function __construct()
    {
        $this->favoriteTeams = new ArrayCollection();
        $this->trophiesForecast = new ArrayCollection();
        $this->startingFive = new ArrayCollection();
    }

    public function getId(): int
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProfileImageUrl(): ?string
    {
        return $this->profileImageUrl;
    }

    public function setProfileImageUrl(?string $profileImageUrl): self
    {
        $this->profileImageUrl = $profileImageUrl;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function setTop100(Top100 $top100): self
    {
        $this->top100 = $top100;

        return $this;
    }

    public function getTop100(): ?Top100
    {
        return $this->top100;
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

    public function getTrophiesForecast(): Collection
    {
        return $this->trophiesForecast;
    }

    public function addTrophyForecast(TrophyForecast $trophyForecast): self
    {
        if (!$this->trophiesForecast->contains($trophyForecast)) {
            $this->trophiesForecast->add($trophyForecast);
            $trophyForecast->setUserProfile($this);
        }

        return $this;
    }

    public function getStartingFive(): Collection
    {
        return $this->startingFive;
    }

    public function addStartingFive(StartingFive $startingFive): self
    {
        if (!$this->startingFive->contains($startingFive)) {
            $this->startingFive->add($startingFive);
            $startingFive->setUser($this);
        }

        return $this;
    }

    public function getFavoriteTeams(): Collection
    {
        return $this->favoriteTeams;
    }

    public function addFavoriteTeam(Team $team): self
    {
        if (!$this->favoriteTeams->contains($team)) {
            $this->favoriteTeams[] = $team;
        }

        return $this;
    }

    public function cleanAllFavoriteTeams(): self
    {
        foreach($this->getFavoriteTeams() as $team) {
            $this->removeFavoriteTeam($team);
        }
        return $this;
    }

    public function removeFavoriteTeam(Team $team): self
    {
        $this->favoriteTeams->removeElement($team);

        return $this;
    }


}