<?php

namespace App\Tests\Domain\Draft\Lottery;

use App\Domain\Draft\Lottery\LotteryService;
use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Infrastructure\Context\Context;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class LotteryServiceTest extends KernelTestCase
{

    use FixturesTrait;

    public function testGetTeamsForLottery()
    {
        $data = $this->loadFixtures(['lottery']);

        /** @var Season $season */
        $season = $data['season_1'];

        /** @var League $league */
        $league = $data['nba'];

        $context = new Context($this->em);
        $context->initContext($league, $season, CompetitionType::COMPETITION_DRAFT);

        $lotteryService = new LotteryService();

        $standings = $lotteryService->getTeamsForLottery($context);

        $this->assertEquals(15, $standings->count());

        foreach ($standings as $standing) {
            $this->assertNotNull($standing->getOdd());
        }
    }

}