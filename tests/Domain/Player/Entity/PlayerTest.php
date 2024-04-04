<?php

namespace App\Tests\Domain\Player\Entity;

use App\Domain\Player\Entity\Player;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class PlayerTest extends KernelTestCase
{

    use FixturesTrait;

    public function getEntity(): Player
    {
        /** @var Player $player */
        ['player_1' => $player] = $this->loadFixtures(['player']);
        return $player;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNameIsNotBlank()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }

    public function testBirthPlaceIsNotBlank()
    {
        $this->assertHasErrors($this->getEntity()->setBirthPlace(''), 1);
    }

    public function testHypeScoreISZeoOrPositive()
    {
        $this->assertHasErrors($this->getEntity()->setHypeScore(-5), 1);
    }

}