<?php

namespace App\Entity\Library;

use App\Repository\Library\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read:user')]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    #[Groups('read:user')]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[ORM\Column(unique: true, nullable: true)]
    private ?string $twitterId = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: UserProfile::class)]
    #[Groups('read:user')]
    private ?UserProfile $profile = null;

    #[ORM\Column]
    #[Groups('read:user')]
    private array $roles = [];

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

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ForecastRegularSeason::class, orphanRemoval: true)]
    #[Groups('read:user')]
    private Collection $forecastRegularSeason;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: StartingFive::class, orphanRemoval: true)]
    #[Groups('read:user')]
    private Collection $startingFive;

    public function __construct()
    {
        $this->forecastRegularSeason = new ArrayCollection();
        $this->startingFive = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTwitterId(): ?string
    {
        return $this->twitterId;
    }

    public function setTwitterId(string $twitterId): self
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    public function setProfile(UserProfile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getProfile(): ?UserProfile
    {
        return $this->profile;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    public function getForecastRegularSeason(): Collection
    {
        return $this->forecastRegularSeason;
    }

    public function addForecastRegularSeason(ForecastRegularSeason $forecastRegularSeason): self
    {
        if (!$this->forecastRegularSeason->contains($forecastRegularSeason)) {
            $this->forecastRegularSeason->add($forecastRegularSeason);
            $forecastRegularSeason->setUser($this);
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
}
