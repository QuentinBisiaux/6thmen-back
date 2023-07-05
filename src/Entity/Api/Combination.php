<?php

namespace App\Entity\Api;

use App\Entity\Library\Standing;
use App\Entity\Library\Team;
use Doctrine\Common\Collections\Collection;

class Combination
{
    private array $rawCombinations;

    private array $combinationsTeam = [];

    const MAX_COMBINATION = 1001;

    const MAX_PING_PONG_BALL = 14;

    const PING_PONG_BALLS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];


    public function __construct()
    {
        $workingNumber = 1;
        while ($workingNumber < self::MAX_PING_PONG_BALL) {
            $lockedNumber1 = $workingNumber + 1;
            $lockedNumber2 = $workingNumber + 2;
            $lockedNumber3 = $workingNumber + 3;
            while ($lockedNumber1 <= self::MAX_PING_PONG_BALL) {
                while ($lockedNumber2 <= self::MAX_PING_PONG_BALL) {
                    while ($lockedNumber3 <= self::MAX_PING_PONG_BALL) {
                        $this->rawCombinations[] = "$workingNumber,$lockedNumber1,$lockedNumber2,$lockedNumber3";
                        $lockedNumber3++;
                    }
                    $lockedNumber2++;
                    $lockedNumber3 = $lockedNumber2 + 1;
                }
                $lockedNumber1++;
                $lockedNumber2 = $lockedNumber1+ 1;
                $lockedNumber3 = $lockedNumber2 + 1;
            }
            $workingNumber++;
        }
        /*for ($workingNumber = 1; $workingNumber < self::MAX_PING_PONG_BALL - 2; $workingNumber++) {
            for ($lockedNumber1 = $workingNumber + 1; $lockedNumber1 < self::MAX_PING_PONG_BALL - 1; $lockedNumber1++) {
                for ($lockedNumber2 = $lockedNumber1 + 1; $lockedNumber2 < self::MAX_PING_PONG_BALL; $lockedNumber2++) {
                    for ($lockedNumber3 = $lockedNumber2 + 1; $lockedNumber3 < self::MAX_PING_PONG_BALL; $lockedNumber3++) {
                        $this->rawCombinations[] = [$workingNumber, $lockedNumber1, $lockedNumber2, $lockedNumber3];
                    }
                }
            }
        }*/
    }

    public function setCombinationsToTeams(Collection $standings): void
    {
        $key = array_rand($this->rawCombinations);
        unset($this->rawCombinations[$key]);

        foreach ($standings as $standing)
        {
            for ($x = 0; $x < (self::MAX_COMBINATION - 1) * $standing->getOdds() / 100; $x++) {
                $key = array_rand($this->rawCombinations);
                $this->combinationsTeam[$this->rawCombinations[$key]] = $standing;
                unset($this->rawCombinations[$key]);
            }
        }
    }

    public function draw(): Standing
    {
        $key = '';
        while(!array_key_exists($key, $this->combinationsTeam)) {
            $key = $this->drawWinningCombination();
        }
        return $this->combinationsTeam[$key];
    }

    private function drawWinningCombination(): string
    {
        $combination = array_rand(array_flip(self::PING_PONG_BALLS), 4);

        return implode(',', $combination);
    }

}