<?php

namespace App\Domain\Draft\Lottery\Entity;


use App\Domain\Team\Team;
use Doctrine\Common\Collections\Collection;

class Lottery
{
    private Combination $combination;
    private array $results = [];
    private array $drawnTeams = [];

    public function __construct
    (
        private Collection $standings,
    )
    {
        $this->combination = new Combination();
        $this->combination->setCombinationsToTeams($standings);
        $this->setResults();
    }

    public function getResults(): array
    {
        return $this->results;
    }

    private function setResults(): void
    {
        while(count($this->results) < 4) {
            $result = $this->combination->draw();
            if($this->isAlreadyDrawn($result->getTeam())) {
                continue;
            }
            $this->results[] = $result;
            $this->drawnTeams[$result->getTeam()->getId()] = true;
        }
        $standings = $this->standings;
        foreach ($standings as $standing) {
            if($this->isAlreadyDrawn($standing->getTeam())) {
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
