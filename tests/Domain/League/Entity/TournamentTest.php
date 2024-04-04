<?php

namespace App\Tests\Domain\League\Entity;

use App\Domain\League\Entity\Tournament;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class TournamentTest extends KernelTestCase
{
    use FixturesTrait;
    public function getEntity(): Tournament
    {
        /** @var Tournament $tournament */
        ['tournament_1' => $tournament] = $this->loadFixtures(['tournament']);
        return $tournament;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNotBlankName()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }

    public function testEndAtAlwaysGreaterThanStartAt()
    {
        $tournament = $this->getEntity();
        $endAt = $tournament->getStartAt()->modify('-7 days');
        $this->assertHasErrors($tournament->setEndAt($endAt), 1);
    }

    public function testStartAtMustBeInsideCompetitionDuration()
    {
        $tournament = $this->getEntity();
        $competitionStart   = $tournament->getCompetition()->getStartAt();
        $competitionEnd     = $tournament->getCompetition()->getEndAt();
        $dateBeforeCompetition = $competitionStart->modify('-6 months');
        $dateAfterCompetition = $competitionEnd->modify('+6 months');
        $this->assertHasErrors($tournament->setStartAt($dateBeforeCompetition), 1);
        $this->assertHasErrors($tournament->setStartAt($dateAfterCompetition), 2);
    }

    public function testEndAtMustBeInsideCompetitionDuration()
    {
        $tournament = $this->getEntity();
        $competitionStart   = $tournament->getCompetition()->getStartAt();
        $competitionEnd     = $tournament->getCompetition()->getEndAt();
        $dateBeforeCompetition = $competitionStart->modify('-6 months');
        $dateAfterCompetition = $competitionEnd->modify('+6 months');
        $this->assertHasErrors($tournament->setEndAt($dateBeforeCompetition), 2);
        $this->assertHasErrors($tournament->setEndAt($dateAfterCompetition), 1);
    }

}
