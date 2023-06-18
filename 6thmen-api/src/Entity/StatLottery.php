<?php

namespace App\Entity;

use App\Repository\StatLotteryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatLotteryRepository::class)]
class StatLottery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column]
    private array $result = [];

    #[ORM\Column]
    private \DateTimeImmutable $done_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function setResult(array $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getDoneAt(): ?\DateTimeImmutable
    {
        return $this->done_at;
    }

    public function setDoneAt(\DateTimeImmutable $done_at): self
    {
        $this->done_at = $done_at;

        return $this;
    }
}
