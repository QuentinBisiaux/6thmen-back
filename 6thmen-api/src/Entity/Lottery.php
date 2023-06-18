<?php

namespace App\Entity;


use App\Repository\TeamRepository;

class Lottery
{
    private Combination $combination;

    private array $results = [];

    public function __construct
    (
        private TeamRepository $teamRepository
    )
    {
        $this->combination = new Combination();
        $this->combination->setRawCombinations();
        $teamsByRank = $this->teamRepository->findTeamsByRankWithOdds();
        $this->combination->setCombinationsToTeams($teamsByRank);
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
        $teamsByRank = $this->teamRepository->findTeamsByRankWithOdds();
        foreach ($teamsByRank as $team) {
            if($this->isAlreadyDrawn($team)) {
                continue;
            }
            $this->results[] = $team;
        }
    }

    private function isAlreadyDrawn(Team $team): bool
    {
        foreach ($this->results as $drawnTeam) {
            if($drawnTeam->getId() === $team->getId()) {
                return true;
            }
        }
        return false;
    }
}
