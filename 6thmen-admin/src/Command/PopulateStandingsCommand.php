<?php

namespace App\Command;

use App\Entity\Standing;
use App\Repository\LeagueRepository;
use App\Repository\SeasonRepository;
use App\Repository\StandingRepository;
use App\Repository\TeamRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'populate:standings',
    description: 'Add a short description for your command',
)]
class PopulateStandingsCommand extends Command
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

    public function __construct(
        private TeamRepository $teamRepository,
        private EntityManagerInterface $manager,
        private LeagueRepository $leagueRepository,
        private SeasonRepository $seasonRepository
    )
    {
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
            $io->success('will Insert ' .$season->getYear() . ' - ' . $league->getName() . ' ' . $team->getName() );
        }
        $this->manager->flush();

        return Command::SUCCESS;
    }
}