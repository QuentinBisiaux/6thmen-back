<?php

namespace App\Tests\Domain\League\Entity;

use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Trophy;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class TrophyTest extends KernelTestCase
{
    use FixturesTrait;
    public function getEntity(): Trophy
    {
        /** @var Trophy $trophy */
        ['trophy_1' => $trophy] = $this->loadFixtures(['trophy']);
        return $trophy;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNotBlankName()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }

    public function testNotBlankAbbreviation()
    {
        $this->assertHasErrors($this->getEntity()->setAbbreviation(''), 1);
    }
}