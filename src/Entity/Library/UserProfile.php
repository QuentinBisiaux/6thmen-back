<?php

namespace App\Entity\Library;

use App\Repository\Library\UserDataRepository;
use App\Service\EncryptionService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: UserDataRepository::class)]
#[ORM\Table(name: '`user_data`')]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    #[Groups('read:user')]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    #[Groups('read:user')]
    private ?string $username = null;

    /** @var Collection <int, Team>  */
    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'fans')]
    #[JoinTable(name: 'user_favorite_teams')]
    #[Groups('read:user')]
    private Collection $favoriteTeams;

    #[ORM\Column]
    #[Groups('read:user')]
    private ?string $profileImageUrl = null;

    #[ORM\Column]
    #[Groups('read:user')]
    private ?string $location = null;

    #[ORM\Column(type: 'json', nullable : false)]
    private array $rawData;

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

    public function __construct()
    {
        $this->favoriteTeams = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

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

    public function getRawData(EncryptionService $encryptionService): array
    {
        $decryptedData = [];
        foreach ($this->rawData as $key => $securedData) {
            if(is_array($securedData)) {
                $decryptedData[$key] = $securedData;
                continue;
            }
            $decryptedData[$key] = $securedData !== null ? $this->encryptionService->decrypt($securedData) : null;
        }
        return $decryptedData;
    }

    public function setRawData(array $rawData, EncryptionService $encryptionService): self
    {
        $securedData = [];
        foreach ($rawData as $key => $data) {
            if(is_array($data)) {
                $securedData[$key] = $data;
                continue;
            }
            $securedData[$key] = $data !== null ? $encryptionService->encrypt($data) : null;
        }
        $this->rawData = $securedData;

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