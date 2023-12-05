<?php

namespace App\Command;

use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'init:db:data',
    description: 'Add a short description for your command',
)]
class InitDbDataCommand extends Command
{
    private array $leaguesBySports = [
        'BasketBall' => ['ABA', 'BAA', 'NBA', 'NBL', 'NCAA', 'EUROLEAGUE'],
        'Soccer' => ['FIFA', 'UEFA'],
        'Football' => ['NFL']
    ];

    const CONST_PATH_COUNTRIES = __DIR__ . '/../../var/data/countries.csv';

    public function __construct(
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->leaguesBySports as $sport => $leagues) {
            $sportToInsert = new Sport();
            $sportToInsert->setName($sport);
            $sportToInsert->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($sportToInsert);
            foreach ($leagues as $league) {
                $leagueToInsert = new League();
                $leagueToInsert->setName($league);
                $leagueToInsert->setCreatedAt(new \DateTimeImmutable());
                $leagueToInsert->setSport($sportToInsert);
                $this->manager->persist($leagueToInsert);
            }
        }
        for ($startingYear = 1850; $startingYear <= 2150; $startingYear++) {
            $season = new Season();
            $season->setYear($startingYear);
            $season->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($season);
            $this->manager->flush();
            $seasonMult = new Season();
            $seasonMult->setYear($startingYear . '-' . substr($startingYear + 1, -2));
            $seasonMult->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($seasonMult);
        }
        $this->manager->flush();
        return self::SUCCESS;
    }

}