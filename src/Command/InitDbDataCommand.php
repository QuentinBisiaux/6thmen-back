<?php

namespace App\Command;

use App\Domain\League\Entity\Competition;
use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Sport;
use App\Domain\League\Entity\Tournament;
use App\Domain\League\Entity\Trophy;
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
            'aba',
            'baa',
            'nba',
            'ncaa',
            'euroleague'
        ],
        'Soccer' => [
            'fifa',
            'uefa'
        ],
        'Football' => [
            'nfl'
        ]
    ];

    private array $trophies = [
        'MVP'   => 'Most Valuable Player',
        'ROY'   => 'Rookie Of the Year',
        'DPOY'  => 'Defensive Player Of the Year',
        'MIP'   => 'Most Improve Player',
        ''      => 'Sixth Men Of the Year',
    ];

    private array $tournamentsByCompetition = [
        'Regular Season'    => [
            'FirstThird'    => ['start' => '-10-24 00:00:00', 'end' => '-12-19 23:59:59'],
            'Allstar'       => ['start' => '-12-20 00:00:00', 'end' => '-02-14 22:59:59'],
            'LastThird'     => ['start' => '-02-15 00:00:00', 'end' => '-02-15 23:59:59']
        ],
        'Post Season'       => [
            'Play-In'       => ['start' => '-04-16 00:00:00', 'end' => '-04-19 23:59:59'],
            'Playoff'       => ['start' => '-04-20 00:00:00', 'end' => '-06-05 23:59:59'],
            'Finals'        => ['start' => '-06-06 00:00:00', 'end' => '-07-01 23:59:59']
        ],
        'Draft'             => [],
        'Off Season'        => []
    ];

    public function __construct(
        private readonly EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->createAllSportsAndLeagues();

        for ($startingYear = 1935; $startingYear <= 2045; $startingYear++) {
            $season = $this->manager->getRepository(Season::class)->findOneBy(['year' => $startingYear]);
            if(!$season) {
                $season = new Season();
                $season->setYear((string) $startingYear);
                $season->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($season);
            }

            $yearMult = $startingYear . '-' . substr((string) ($startingYear + 1), -2);
            $seasonMult = $this->manager->getRepository(Season::class)->findOneBy(['year' => $yearMult]);
            if(!$seasonMult) {
                $seasonMult = new Season();
                $seasonMult->setYear($yearMult);
                $seasonMult->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($seasonMult);
            }
            foreach ($this->tournamentsByCompetition as $competitionName => $tournaments) {
                $league = $this->manager->getRepository(League::class)->findOneBy(['name' => 'nba']);
                $competition = $this->manager->getRepository(Competition::class)->findOneBy(
                    [
                        'name' => $competitionName,
                        'league' => $league,
                        'season' => $seasonMult]
                );
                if(!$competition) {
                    $competition = new Competition();
                    $competition->setName($competitionName);
                    $competition->setLeague($league);
                    $competition->setSeason($seasonMult);
                    $competition->setGames(82);
                    $competition->setStartAt(new \DateTimeImmutable($startingYear . '-09-01'));
                    $competition->setEndAt(new \DateTimeImmutable($startingYear + 1 . '-05-15'));
                    $competition->setCreatedAt(new \DateTimeImmutable());
                    if($competitionName === CompetitionType::COMPETITION_REGULAR_SEASON) {
                        $this->createTrophies($competition);
                    }
                    $this->manager->persist($competition);
                }

                foreach ($tournaments as $tournamentName => $details) {
                    $tournament = $this->manager->getRepository(Tournament::class)->findOneBy(['name' => $tournamentName, 'competition' => $competition]);
                    if(!$tournament) {
                        $tournament = new Tournament();
                        $tournament->setName($tournamentName);
                        $tournament->setCompetition($competition);
                        $tournament->setStartAt(new \DateTimeImmutable($startingYear . '-09-01'));
                        $tournament->setEndAt(new \DateTimeImmutable($startingYear + 1 . '-05-15'));
                        $tournament->setCreatedAt(new \DateTimeImmutable());
                        $this->manager->persist($tournament);
                    }
                }
            }
        }

        $this->manager->flush();
        return self::SUCCESS;
    }

    private function createAllSportsAndLeagues(): void
    {
        foreach ($this->leaguesBySports as $sportName => $leagues) {
            $sport = $this->manager->getRepository(Sport::class)->findOneBy(['name' => $sportName]);
            if (!$sport) {
                $sport = new Sport();
                $sport->setName($sportName);
                $sport->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($sport);
            }

            foreach ($leagues as $leagueName) {
                $league = $this->manager->getRepository(League::class)->findOneBy(['name' => $leagueName]);
                if (!$league) {
                    $league = new League();
                    $league->setName($leagueName);
                    $league->setCreatedAt(new \DateTimeImmutable());
                    $league->setSport($sport);
                    $this->manager->persist($league);
                }
            }
        }
        $this->manager->flush();
    }

    private function createTrophies(Competition $competition): void
    {
        foreach($this->trophies as $abbrev => $name) {
            $trophy = new Trophy();
            $trophy->setName($name)->setAbbreviation($abbrev)->setCreatedAt(new \DateTime())->setCompetition($competition);
            $this->manager->persist($trophy);
        }
    }

}