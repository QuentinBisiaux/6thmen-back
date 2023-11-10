<?php

namespace App\Entity\Api;

use App\Entity\Library\StandingDraft;
use Doctrine\Common\Collections\Collection;

class Combination
{
    private array $rawCombinations;

    private array $combinationsTeam = [];

    const MAX_COMBINATION = 1001;

    const PING_PONG_BALLS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];


    public function __construct()
    {
        $count = 0;
        $size = count(self::PING_PONG_BALLS);

        for ($i = 0; $i < $size - 3; $i++) {
            for ($j = $i + 1; $j < $size - 2; $j++) {
                for ($k = $j + 1; $k < $size - 1; $k++) {
                    for ($l = $k + 1; $l < $size; $l++) {
                        $this->rawCombinations[] = implode(',', [
                            self::PING_PONG_BALLS[$i],
                            self::PING_PONG_BALLS[$j],
                            self::PING_PONG_BALLS[$k],
                            self::PING_PONG_BALLS[$l]
                        ]);

                        $count++;
                        if ($count >= self::MAX_COMBINATION) {
                            break 4; // Exit all loops if the maximum number of combinations is reached
                        }
                    }
                }
            }
        }
    }

    public function setCombinationsToTeams(Collection $standings): void
    {
        foreach ($standings as $standing) {
            $combinationsCount = (int) ((self::MAX_COMBINATION - 1) * $standing->getOdds() / 100);
            $keys = (array) array_rand($this->rawCombinations, $combinationsCount);
            foreach ($keys as $key) {
                $this->combinationsTeam[$this->rawCombinations[$key]] = $standing;
                unset($this->rawCombinations[$key]);
            }
        }
    }

    public function draw(): StandingDraft
    {
        return $this->combinationsTeam[array_rand($this->combinationsTeam)];
    }

}