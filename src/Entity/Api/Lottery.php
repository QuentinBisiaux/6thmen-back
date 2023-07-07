<?php

namespace App\Entity\Api;


use App\Entity\Library\StandingDraft;
use Doctrine\Common\Collections\Collection;

class Lottery
{
    private Combination $combination;

    private array $results = [];

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
        $counter = 0;
        while($counter < 4) {
            $result = $this->combination->draw();
            if($this->isAlreadyDrawn($result)) {
                continue;
            }
            $this->results[$counter] = $result;
            $counter++;
        }
        $standings = $this->standings;
        foreach ($standings as $standing) {
            if($this->isAlreadyDrawn($standing)) {
                continue;
            }
            $this->results[] = $standing;
        }
    }

    private function isAlreadyDrawn(StandingDraft $team): bool
    {
        foreach ($this->results as $drawnTeam) {
            if($drawnTeam->getId() === $team->getId()) {
                return true;
            }
        }
        return false;
    }
}
