<?php

namespace App\Domain\Draft\Lottery;

use App\Domain\Draft\Lottery\Entity\Combination;
use App\Domain\Draft\Lottery\Entity\Lottery;
use App\Domain\Draft\Lottery\Entity\Odds;
use App\Domain\League\Entity\Season;
use App\Domain\Standing\StandingDraftService;
use Doctrine\Common\Collections\Collection;

class LotteryService
{
    public function getTeamsForLottery(Season $season): Collection
    {
        return $this->addOddsToStandingDrafts($season->getStandingDrafts());
    }

    public function launch(Season $season): array
    {
        $standingsDraftWithOdds = $this->addOddsToStandingDrafts($season->getStandingDrafts());
        $combination = new Combination();
        $combination->setCombinationsToTeams($standingsDraftWithOdds);
        $lottery = new Lottery($standingsDraftWithOdds, $combination);

        return $lottery->launchDraw()->getResults();

    }

    private function addOddsToStandingDrafts(Collection $standingsDraft): Collection
    {
        foreach ($standingsDraft as $standingDraft) {
            $standingDraft->setOdds(Odds::ODDS[$standingDraft->getRank() - 1]);
        }
        return $standingsDraft;
    }

}