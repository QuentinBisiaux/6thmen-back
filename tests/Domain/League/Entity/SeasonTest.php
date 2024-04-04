<?php

namespace App\Tests\Domain\League\Entity;

use App\Domain\League\Entity\Season;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class SeasonTest extends KernelTestCase
{
    use FixturesTrait;
    public function getEntity(): Season
    {
        /** @var Season $season */
        ['season_2022_23' => $season] = $this->loadFixtures(['season']);
        return $season;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNotBlankYear()
    {
        $this->assertHasErrors($this->getEntity()->setYear(''), 1);
    }

    public function testYearSimpleAndMultiFormat()
    {
        $this->assertHasErrors($this->getEntity()->setYear('azer'), 1);
        $this->assertHasErrors($this->getEntity()->setYear('1231-'), 1);
        $this->assertHasErrors($this->getEntity()->setYear('1231-1'), 1);
        $this->assertHasErrors($this->getEntity()->setYear('1231!11'), 1);
        $this->assertHasErrors($this->getEntity()->setYear('1231-a1'), 1);
    }



}