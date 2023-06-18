<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[UniqueEntity('name')]
#[UniqueEntity('rank')]
class Team
{
    const MAX_VICTORY = 82;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 150, unique: true)]
    private ?string $name = null;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\LessThanOrEqual(self::MAX_VICTORY)]
    #[Assert\NotBlank]
    #[ORM\Column]
    private ?int $victory = null;

    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(30)]
    #[Assert\NotBlank]
    #[ORM\Column(unique: true)]
    private ?int $rank = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\LessThanOrEqual(14)]
    private float $odds;

    private string $slug;

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

    public function getVictory(): ?int
    {
        return $this->victory;
    }

    public function setVictory(int $victory): self
    {
        $this->victory = $victory;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getOdds(): float
    {
        return $this->odds;
    }

    public function setOdds(float $odds): self
    {
        $this->odds = $odds;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(): self
    {
        $this->slug = implode('_', explode(' ', $this->getName()));

        return $this;
    }




}
