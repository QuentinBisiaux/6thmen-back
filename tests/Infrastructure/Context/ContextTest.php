<?php

namespace App\Tests\Infrastructure\Context;

use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Infrastructure\Context\Context;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class ContextTest extends KernelTestCase
{

    use FixturesTrait;

    public function getContextByType(string $competitionType): Context
    {
        $context = new Context($this->em);

        $data = $this->loadFixtures(['context']);

        /** @var Season $season */
        $season = $data['season_1'];

        /** @var League $season */
        $league = $data['nba'];

        $context->initContext($league, $season, $competitionType);

        return $context;
    }

    public function testCorrectDraftContext()
    {
        $context = $this->getContextByType(CompetitionType::COMPETITION_DRAFT);
        $this->assertEquals(CompetitionType::COMPETITION_DRAFT, $context->getCompetition()->getName());
    }

    public function testCorrectRegularSeasonContext()
    {
        $context = $this->getContextByType(CompetitionType::COMPETITION_REGULAR_SEASON);
        $this->assertEquals(CompetitionType::COMPETITION_REGULAR_SEASON, $context->getCompetition()->getName());
    }

    public function testCorrectPlayoffContext()
    {
        $context = $this->getContextByType(CompetitionType::COMPETITION_PLAYOFF);
        $this->assertEquals(CompetitionType::COMPETITION_PLAYOFF, $context->getCompetition()->getName());
    }

}