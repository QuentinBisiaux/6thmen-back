<?php

namespace App\Domain\Draft\Lottery;

use App\Domain\Draft\Lottery\Entity\Combination;
use App\Domain\Draft\Lottery\Entity\Lottery;
use App\Domain\Draft\Lottery\Entity\Odds;
use App\Infrastructure\Context\Context;
use Doctrine\Common\Collections\Collection;

class LotteryService
{

    public function getTeamsForLottery(Context $context): Collection
    {
        return $this->addOddsToStandingDrafts($context->getCompetition()->getStandings());
    }

    public function launch(Context $context): array
    {
        $standingsWithOdds = $this->getTeamsForLottery($context);
        $combination = new Combination();
        $combination->setCombinationsToTeams($standingsWithOdds);
        $lottery = new Lottery($standingsWithOdds, $combination);

        return $lottery->launchDraw()->getResults();

    }

    private function addOddsToStandingDrafts(Collection $standings): Collection
    {
        foreach ($standings as $standing) {
            $standing->setOdd(Odds::ODDS[$standing->getRank() - 1]);
        }
        return $standings;
    }

}