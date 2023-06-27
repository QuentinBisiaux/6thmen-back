<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use App\Entity\Country;
use App\Entity\PlayerTeams;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[Groups(['player'])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['player'])]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $firstname = null;

    #[Groups(['player'])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lastname = null;

    #[Groups(['player'])]
    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Country $birthPlace = null;

    #[Groups(['player'])]
    #[ORM\Column(nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTimeImmutable::RFC3339],
    )]
    private ?\DateTimeImmutable $birthday = null;

    #[Groups(['player_team'])]
    #[ORM\OneToMany(mappedBy: 'player', targetEntity: PlayerTeams::class)]
    private Collection $playerTeams;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->playerTeams = new ArrayCollection();
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
     * @return Collection<int, PlayerTeams>
     */
    public function getPlayerTeams(): Collection
    {
        return $this->playerTeams;
    }

    public function addPlayerTeam(PlayerTeams $playerTeam): self
    {
        if (!$this->playerTeams->contains($playerTeam)) {
            $this->playerTeams->add($playerTeam);
            $playerTeam->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerTeam(PlayerTeams $playerTeam): self
    {
        if ($this->playerTeams->removeElement($playerTeam)) {
            // set the owning side to null (unless already changed)
            if ($playerTeam->getPlayer() === $this) {
                $playerTeam->setPlayer(null);
            }
        }

        return $this;
    }
}
