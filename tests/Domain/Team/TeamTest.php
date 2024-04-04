<?php

namespace App\Tests\Domain\Team;

use App\Domain\Team\Team;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class TeamTest extends KernelTestCase
{
    use FixturesTrait;

    public function getEntity(): Team
    {
        /** @var Team $team */
        ['valid_team' => $team] = $this->loadFixtures(['team']);
        return $team;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNotBlankName()
    {
        $team = $this->getEntity()->setTricode('');
        $this->assertHasErrors($team, 2);
    }

    public function testNotBlankTricode()
    {
        $team = $this->getEntity()->setTricode('');
        $this->assertHasErrors($team, 2);
    }

    public function testTricodeLength()
    {
        $this->assertHasErrors($this->getEntity()->setTricode('AB'), 2);
        $this->assertHasErrors($this->getEntity()->setTricode('ABCC'), 2);
    }

    public function testTricodeOnlyCapitalLetters()
    {
        $this->assertHasErrors($this->getEntity()->setTricode('AbC'), 1);
        $this->assertHasErrors($this->getEntity()->setTricode('123'), 1);
        $this->assertHasErrors($this->getEntity()->setTricode('abc'), 1);
        $this->assertHasErrors($this->getEntity()->setTricode('/**'), 1);
    }

    public function testSlugNotBlank()
    {
        $this->assertHasErrors($this->getEntity()->setSlug(''), 1);
    }

    public function testSlugFormat()
    {
        $this->assertHasErrors($this->getEntity()->setSlug('/'), 1);
        $this->assertHasErrors($this->getEntity()->setSlug('azerty/'), 1);
        $this->assertHasErrors($this->getEntity()->setSlug('/azerty'), 1);
    }

    public function testNotBlankConference()
    {
        $team = $this->getEntity()->setConference('');
        $this->assertHasErrors($team, 1);
    }

    public function testEndedInAlwaysAfterCreatedIn()
    {
        $team = $this->getEntity();
        $team->setCreatedIn(new \DateTime('12/31/1990'));
        $team->setEndedIn(new \DateTime('12/31/1980'));
        $this->assertHasErrors($team, 1);
    }

    public function testCascadeOnFranchiseDelete()
    {
        $team = $this->getEntity();
        $teamRepository = $this->em->getRepository(Team::class);
        $teamId = $team->getId();
        $franchise = $team->getFranchise();
        $this->remove($franchise);
        $this->em->flush();
        $this->em->clear();
        $this->assertEquals(null, $teamRepository->find($teamId));
    }
    
}