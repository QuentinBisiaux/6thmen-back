<?php

namespace App\Tests\Domain\Draft\Lottery\Entity;

use App\Domain\Draft\Lottery\Entity\Combination;
use PHPUnit\Framework\TestCase;

class CombinationTest extends TestCase
{

    public function testCombinationCount(): void
    {
        $combinations = new Combination();
        $this->assertCount(1001, $combinations->getRawCombinations());
    }

    public function testCombinationUniqueness(): void
    {
        $combinations = new Combination();
        $this->assertCount(1001, array_unique($combinations->getRawCombinations()));
    }

    public function testCombinationFormat(): void
    {
        $combinations = new Combination();
        foreach ($combinations->getRawCombinations() as $combination) {
            $this->assertMatchesRegularExpression('/^(\\d{1,2},){3}\\d{1,2}$/', $combination);
        }
    }

}