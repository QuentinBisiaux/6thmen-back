<?php

namespace App\DataFixtures;

use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private array $leaguesBySports = [
        'BasketBall' => ['ABA', 'BAA', 'NBA', 'NBL', 'NCAA', 'EUROLEAGUE'],
        'Soccer' => ['FIFA', 'UEFA'],
        'Football' => ['NFL']
    ];

    public function load(ObjectManager $manager): void
    {

        foreach ($this->leaguesBySports as $sport => $leagues) {
            $sportToInsert = new Sport();
            $sportToInsert->setName($sport);
            $sportToInsert->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($sportToInsert);
            foreach ($leagues as $league) {
                $leagueToInsert = new League();
                $leagueToInsert->setName($league);
                $leagueToInsert->setCreatedAt(new \DateTimeImmutable());
                $leagueToInsert->setSport($sportToInsert);
                $manager->persist($leagueToInsert);
            }
        }
        for ($startingYear = 1850; $startingYear <= 2150; $startingYear++) {
            $season = new Season();
            $season->setYear($startingYear);
            $season->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($season);
            $manager->flush();
            $seasonMult = new Season();
            $seasonMult->setYear($startingYear . '-' . substr($startingYear + 1, -2));
            $seasonMult->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($seasonMult);
        }
        $manager->flush();
    }
}
