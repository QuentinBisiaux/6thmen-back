<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixture extends Fixture
{
    private array $teams = [
        [
            'name'      => 'Detroit Pistons',
            'victory'   => 17,
            'rank'      => 30
        ],
        [
            'name'      => 'Houston Rockets',
            'victory'   => 22,
            'rank'      => 29
        ],
        [
            'name'      => 'San Antonio Spurs',
            'victory'   => 22,
            'rank'      => 28
        ],
        [
            'name'      => 'Charlotte Hornets',
            'victory'   => 27,
            'rank'      => 27
        ],
        [
            'name'      => 'Portland Trailblazers',
            'victory'   => 33,
            'rank'      => 26
        ],
        [
            'name'      => 'Orlando Magic',
            'victory'   => 34,
            'rank'      => 25
        ],
        [
            'name'      => 'Indiana Pacers',
            'victory'   => 35,
            'rank'      => 24
        ],
        [
            'name'      => 'Washington Wizards',
            'victory'   => 35,
            'rank'      => 23
        ],
        [
            'name'      => 'Utah Jazz',
            'victory'   => 37,
            'rank'      => 22
        ],
        [
            'name'      => 'Dallas Mavericks',
            'victory'   => 38,
            'rank'      => 21
        ],
        [
            'name'      => 'Chicago Bulls',
            'victory'   => 40,
            'rank'      => 20
        ],
        [
            'name'      => 'Oklahoma City Thunder',
            'victory'   => 40,
            'rank'      => 19
        ],
        [
            'name'      => 'Toronto Raptors',
            'victory'   => 41,
            'rank'      => 18
        ],
        [
            'name'      => 'New Orleans Pelicans',
            'victory'   => 42,
            'rank'      => 17
        ],

        ];
    public function load(ObjectManager $manager): void
    {
/*        foreach ($this->teams as $teamAsArray) {
            $team1 = new Team();
            $team1->setName($teamAsArray['name']);
            $team1->setVictory($teamAsArray['victory']);
            $team1->setRank($teamAsArray['rank']);
            $team1->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($team1);
        }*/

        $manager->flush();
    }
}
