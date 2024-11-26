<?php

namespace App\Domain\Team;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Team\Repository\FranchiseRepository;
use App\Validator\Slug as AssertSlug;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: FranchiseRepository::class)]
class Franchise
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups(['read:team', 'read:user'])]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['read:team', 'read:user'])]
    private string $name;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank]
    #[Assert\Length(3)]
    #[Assert\Regex('/^[A-Z]{3}$/')]
    #[Groups(['read:lottery'])]
    private string $tricode;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[AssertSlug]
    #[Groups(['read:team', 'read:user'])]
    private string $slug;

    #[ORM\Column(type: 'date')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private \DateTimeInterface $createdIn;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\GreaterThan(propertyPath: 'createdIn')]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeInterface::RFC3339],
    )]
    private ?\DateTimeInterface $endedIn = null;

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

    /** @var Collection<int, Team>  */
    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: Team::class)]
    private Collection $teams;

    /** @var Collection<int, UserProfile> */
    #[ORM\JoinTable(name: 'franchise_fans')]
    #[ManyToMany(targetEntity: UserProfile::class, mappedBy: 'favoriteFranchises')]
    private Collection $fans;

    public function __construct()
    {
        $this->teams    = new ArrayCollection();
        $this->fans     = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTricode(): string
    {
        return $this->tricode;
    }

    public function setTricode(string $tricode): self
    {
        $this->tricode = $tricode;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedIn(): \DateTimeInterface
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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setFranchise($this);
        }

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

}