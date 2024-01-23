<?php

namespace App\Tests\Domain\Draft\Lottery\Entity;

use App\Domain\Draft\Lottery\Entity\Odds;
use PHPUnit\Framework\TestCase;

class OddsTest extends TestCase
{
    public function testHas30Entries()
    {
        $this->assertCount(30, Odds::ODDS);
    }

}