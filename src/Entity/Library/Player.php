<?php

namespace App\Entity\Library;

use App\Entity\Admin\HypeScore;
use App\Repository\Library\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:player',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lastname = null;

    #[Groups([
        'read:player',
    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:player:details',
    ])]
    private ?Country $birthPlace = null;

    #[ORM\OneToOne(inversedBy: 'player', targetEntity: HypeScore::class)]
    private ?HypeScore $hypeScore = null;

    #[ORM\Column(nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    #[Groups([
        'read:player:details',
    ])]
    private ?\DateTimeImmutable $birthday = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: PlayerTeam::class)]
    private Collection $playerTeams;

    #[ORM\OneToMany(mappedBy: 'players', targetEntity: Top100Player::class)]
    private Collection $top100;

    #[ORM\OneToMany(mappedBy: 'players', targetEntity: StartingFivePlayer::class)]
    private Collection $startingFives;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->playerTeams = new ArrayCollection();
        $this->top100 = new ArrayCollection();
        $this->startingFives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function setName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getBirthPlace(): ?Country
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?Country $birthPlace): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeImmutable $birthDay): self
    {
        $this->birthday = $birthDay;

        return $this;
    }

    public function getHypeScore(): ?HypeScore
    {
        return $this->hypeScore;
    }

    public function setHypeScore(?HypeScore $hypeScore): void
    {
        $this->hypeScore = $hypeScore;
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
            $playerTeam->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerTeam(PlayerTeam $playerTeam): self
    {
        if ($this->playerTeams->removeElement($playerTeam)) {
            // set the owning side to null (unless already changed)
            if ($playerTeam->getPlayer() === $this) {
                $playerTeam->setPlayer(null);
            }
        }

        return $this;
    }

    public function getTop100(): Collection
    {
        return $this->top100;
    }

    public function addToTop100(Top100Player $top100Player): self
    {
        if (!$this->top100->contains($top100Player)) {
            $this->top100->add($top100Player);
            $top100Player->setPlayer($this);
        }

        return $this;
    }

    public function removeFromTop100(Top100Player $top100Player): self
    {
        if ($this->top100->removeElement($top100Player)) {
            // set the owning side to null (unless already changed)
            if ($top100Player->getPlayer() === $this) {
                $top100Player->setPlayer(null);
            }
        }

        return $this;
    }

    public function getStartingFives(): Collection
    {
        return $this->startingFives;
    }

    public function addToStartingFive(StartingFivePlayer $startingFivePlayer): self
    {
        if (!$this->startingFives->contains($startingFivePlayer)) {
            $this->startingFives->add($startingFivePlayer);
            $startingFivePlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeFromStartingFive(StartingFivePlayer $startingFivePlayer): self
    {
        if ($this->top100->removeElement($startingFivePlayer)) {
            // set the owning side to null (unless already changed)
            if ($startingFivePlayer->getPlayer() === $this) {
                $startingFivePlayer->setPlayer(null);
            }
        }

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
