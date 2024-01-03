<?php

namespace App\Command;

use App\Domain\League\Entity\Competition;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Sport;
use App\Domain\League\Entity\Tournament;
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
        'BasketBall' => [
            'ABA' => [],
            'BAA' => [],
            'NBA' => [
                'Regular Season'    => [
                    'FirstThird'    => [],
                    'Allstar'       => [],
                    'LastThird'     => []
                ],
                'Post Season'       => [
                    'Play-In'       => [],
                    'Playoff'       => [],
                    'Finals'        => []
                ]
            ],
            'NBL' => [],
            'NCAA' => [],
            'EUROLEAGUE' => []
        ],
        'Soccer' => [
            'FIFA' => [],
            'UEFA' => []
        ],
        'Football' => ['NFL' => []]
    ];

    private array $competitions = [
        'Regular Season'    => ['FirstThird', 'Allstar', 'LastThird'],
        'Post Season'       => ['Play-In', 'Playoff', 'Finals']
    ];

    public function __construct(
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        for ($startingYear = 1850; $startingYear <= 2150; $startingYear++) {
            $season = $this->manager->getRepository(Season::class)->findOneBy(['year' => $startingYear]);
            if(!$season) {
                $season = new Season();
                $season->setYear($startingYear);
                $season->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($season);
            }

            $yearMult = $startingYear . '-' . substr($startingYear + 1, -2);
            $seasonMult = $this->manager->getRepository(Season::class)->findOneBy(['year' => $yearMult]);
            if(!$seasonMult) {
                $seasonMult = new Season();
                $seasonMult->setYear($yearMult);
                $seasonMult->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($seasonMult);
            }
        }
        $this->manager->flush();

        foreach ($this->leaguesBySports as $sportName => $leagues) {
            $sport = $this->manager->getRepository(Sport::class)->findOneBy(['name' => $sportName]);
            if(!$sport) {
                $sport = new Sport();
                $sport->setName($sportName);
                $sport->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($sport);
            }
            foreach ($leagues as $leagueName => $competitions) {
                $league = $this->manager->getRepository(League::class)->findOneBy(['name' => $leagueName]);
                if(!$league) {
                    $league = new League();
                    $league->setName($leagueName);
                    $league->setCreatedAt(new \DateTimeImmutable());
                    $league->setSport($sport);
                    $this->manager->persist($league);
                }
                if(!empty($competitions)) {
                    $season = $this->manager->getRepository(Season::class)->getMultiYearSeasonByYear('2023-24');
                    foreach ($competitions as $competitionName => $tournaments) {
                        $competition = $this->manager->getRepository(Competition::class)->findOneBy(['name' => $competitionName, 'league' => $league, 'season' => $season]);
                        if(!$competition) {
                            $competition = new Competition();
                            $competition->setName($competitionName);
                            $competition->setLeague($league);
                            $competition->setSeason($season);
                            $this->manager->persist($competition);
                        }

                        foreach ($tournaments as $tournamentName => $details) {
                            $tournament = $this->manager->getRepository(Tournament::class)->findOneBy(['name' => $tournamentName, 'competition' => $competition]);
                            if(!$tournament) {
                                $tournament = new Tournament();
                                $tournament->setName($tournamentName);
                                $tournament->setCompetition($competition);
                                $this->manager->persist($tournament);
                            }
                        }
                    }
                }
            }
        }
        $this->manager->flush();
        return self::SUCCESS;
    }

}