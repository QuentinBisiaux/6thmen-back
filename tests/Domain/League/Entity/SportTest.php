<?php

namespace App\Tests\Domain\League\Entity;

use App\Domain\League\Entity\Sport;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class SportTest extends KernelTestCase
{
    use FixturesTrait;

    public function getEntity(): Sport
    {
        /** @var Sport $sport */
        ['sport_1' => $sport] = $this->loadFixtures(['sport']);
        return $sport;
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