<?php

namespace App\Tests\Domain\Player\Entity;

use App\Domain\Player\Entity\PlayerTeam;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class PlayerTeamTest extends KernelTestCase
{

    use FixturesTrait;

    public function getEntity(): PlayerTeam
    {
        /** @var PlayerTeam $player */
        ['player_team_1' => $player] = $this->loadFixtures(['playerTeam']);
        return $player;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

}