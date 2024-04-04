<?php

namespace App\Tests\Domain\League\Entity;

use App\Domain\League\Entity\League;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class LeagueTest extends KernelTestCase
{
    use FixturesTrait;
    public function getEntity(): League
    {
        /** @var League $league */
        ['league_1' => $league] = $this->loadFixtures(['league']);
        return $league;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNotBlankName()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }
}