<?php

namespace App\Domain\Forecast\Trophy\Entity;

use App\Domain\Forecast\Trophy\Repository\TrophyRepository;
use App\Domain\League\Entity\League;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TrophyRepository::class)]
class Trophy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api:read:forecast-trophies')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Groups('api:read:forecast-trophies')]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('api:read:forecast-trophies')]
    private ?string $abbreviation = null;

    #[ORM\ManyToOne(inversedBy: 'trophies')]
    #[ORM\JoinColumn(nullable: false)]
    private League $league;

    #[ORM\OneToMany(mappedBy: 'trophy', targetEntity: TrophyForecast::class)]
    private Collection $forecasts;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->forecasts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(?string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    public function getLeague(): League
    {
        return $this->league;
    }

    public function setLeague(League $league): void
    {
        $this->league = $league;
    }

    public function getForecasts(): Collection
    {
        return $this->forecasts;
    }

    public function addForecast(TrophyForecast $trophyForecast): self
    {
        if (!$this->forecasts->contains($trophyForecast)) {
            $this->forecasts->add($trophyForecast);
            $trophyForecast->setTrophy($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getKey(): string
    {
        $abbreviationToDisplay = $this->getAbbreviation() !== null ? ' ('.$this->getAbbreviation().')' : '';
        return $this->getName() . $abbreviationToDisplay;
    }

}