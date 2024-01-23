<?php

namespace App\Command;

use App\Domain\League\Repository\LeagueRepository;
use App\Domain\League\Repository\SeasonRepository;
use App\Domain\Standing\Entity\Standing;
use App\Domain\Team\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'populate:standing:full',
    description: 'Add a short description for your command',
)]
class PopulateStandingCommand extends Command
{
    private array $teams = [
        [
            'name'      => 'Detroit Pistons',
            'victory'   => 17,
            'rank'      => 30
        ],
        [
            'name'      => 'San Antonio Spurs',
            'victory'   => 22,
            'rank'      => 29
        ],
        [
            'name'      => 'Houston Rockets',
            'victory'   => 22,
            'rank'      => 28
        ],
        [
            'name'      => 'Charlotte Hornets',
            'victory'   => 27,
            'rank'      => 27
        ],
        [
            'name'      => 'Portland Trail Blazers',
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
            'name'      => 'Oklahoma City Thunder',
            'victory'   => 40,
            'rank'      => 20
        ],
        [
            'name'      => 'Chicago Bulls',
            'victory'   => 40,
            'rank'      => 19
        ],
        [
            'name'      => 'Toronto Raptors',
            'victory'   => 41,
            'rank'      => 18
        ],
        [
            'name'      => 'Atlanta Hawks',
            'victory'   => 41,
            'rank'      => 16
        ],
        [
            'name'      => 'New Orleans Pelicans',
            'victory'   => 42,
            'rank'      => 17
        ],
        [
            'name'      => 'Minnesota Timberwolves',
            'victory'   => 42,
            'rank'      => 15
        ],
        [
            'name'      => 'Los Angeles Lakers',
            'victory'   => 43,
            'rank'      => 14
        ],
        [
            'name'      => 'Golden State Warriors',
            'victory'   => 44,
            'rank'      => 13
        ],
        [
            'name'      => 'Los Angeles Clippers',
            'victory'   => 44,
            'rank'      => 12
        ],
        [
            'name'      => 'Miami Heat',
            'victory'   => 44,
            'rank'      => 11
        ],
        [
            'name'      => 'Brooklyn Nets',
            'victory'   => 45,
            'rank'      => 10
        ],
        [
            'name'      => 'Phoenix Suns',
            'victory'   => 45,
            'rank'      => 9
        ],
        [
            'name'      => 'New York Knicks',
            'victory'   => 47,
            'rank'      => 8
        ],
        [
            'name'      => 'Sacramento Kings',
            'victory'   => 48,
            'rank'      => 7
        ],
        [
            'name'      => 'Cleveland Cavaliers',
            'victory'   => 48,
            'rank'      => 6
        ],
        [
            'name'      => 'Memphis Grizzlies',
            'victory'   => 51,
            'rank'      => 5
        ],
        [
            'name'      => 'Denver Nuggets',
            'victory'   => 53,
            'rank'      => 4
        ],
        [
            'name'      => 'Philadelphia 76ers',
            'victory'   => 54,
            'rank'      => 3
        ],
        [
            'name'      => 'Boston Celtics',
            'victory'   => 57,
            'rank'      => 2
        ],
        [
            'name'      => 'Milwaukee Bucks',
            'victory'   => 58,
            'rank'      => 1
        ]

    ];

    public function __construct(
        private readonly TeamRepository         $teamRepository,
        private readonly EntityManagerInterface $manager,
        private readonly LeagueRepository       $leagueRepository,
        private readonly SeasonRepository       $seasonRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $season = $this->seasonRepository->findOneBy(['year' => '2022-23']);
        $league = $this->leagueRepository->findOneBy(['name' => 'NBA']);
        foreach ($this->teams as $rawStanding) {
            $team = $this->teamRepository->findOneBy(['name' => $rawStanding['name'], 'endedIn' => null]);
            $existingStanding = $this->manager->getRepository(Standing::class)->findOneBy([
                'league' => $league,
                'season' => $season,
                'team' => $team,
                'rank' => $rawStanding['rank']
            ]);
            if ($existingStanding) {
                continue;
            }

            $standing = new Standing();
            $standing
                ->setSeason($season)
                ->setLeague($league)
                ->setTeam($team)
                ->setRank($rawStanding['rank'])
                ->setVictory($rawStanding['victory'])
                ->setLoses(82 - $rawStanding['victory'])
                ->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($standing);
            $io->success('will Insert ' . $season->getYear() . ' - ' . $league->getName() . ' ' . $team->getName());
        }
        $this->manager->flush();

        return Command::SUCCESS;
    }
}
