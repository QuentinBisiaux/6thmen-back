<?php

namespace App\Domain\Draft\Lottery\Entity;

use App\Domain\Team\Team;
use Doctrine\Common\Collections\Collection;

class Lottery
{
    private array $results = [];
    private array $drawnTeams = [];

    public function __construct(
        private readonly Collection $standings,
        private readonly Combination $combination,
    ) {
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function launchDraw(): self
    {
        $this->drawWinners();
        $this->completeResults();
        return $this;
    }

    private function drawWinners(): void
    {
        while (count($this->results) < 4) {
            $result = $this->combination->draw();
            if ($this->isAlreadyDrawn($result->getTeam())) {
                continue;
            }
            $this->results[] = $result;
            $this->drawnTeams[$result->getTeam()->getId()] = true;
        }
    }

    private function completeResults(): void
    {
        $standings = $this->standings;
        foreach ($standings as $standing) {
            if ($this->isAlreadyDrawn($standing->getTeam())) {
                continue;
            }
            $this->results[] = $standing;
        }
    }

    private function isAlreadyDrawn(Team $team): bool
    {
        return isset($this->drawnTeams[$team->getId()]);
    }

}
