<?php

namespace App\Command;

use App\Domain\League\Entity\Competition;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\Team\Franchise;
use App\Domain\Team\Team;
use App\Service\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'create:team',
    description: 'Add a short description for your command',
)]
class CreateTeamCommand extends Command
{
    const CONST_PATH_TEAM = __DIR__ . '/../../var/data/teams/teams.csv';
    const CONST_PATH_TEAM_OLD = __DIR__ . '/../../var/data/teams/teams-old.csv';
    private array $rawTeam = [];
    private Team $newTeam;

    private ?Franchise $lastInsertedFranchise = null;

    public function __construct(
        private FileManager $fileManager,
        private SluggerInterface $slugger,
        private EntityManagerInterface $manager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('old', InputArgument::OPTIONAL, 'setting up old teams');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg = $input->getArgument('old');

        if ($arg === 'old') {
            try {
                $fileContent = $this->fileManager->getFileContent(self::CONST_PATH_TEAM_OLD);
            } catch (FileException $ex) {
                $io->error($ex->getMessage());
            }
        } else {
            try {
                $fileContent = $this->fileManager->getFileContent(self::CONST_PATH_TEAM);
            } catch (FileException $ex) {
                $io->error($ex->getMessage());
            }
        }
        if (empty($fileContent)) {
            $io->error('No data to process');
            return Command::FAILURE;
        }

        array_shift($fileContent);
        foreach ($fileContent as $index => $teamData) {
            $this->populateRawTeam(explode(',', $teamData));
            if ($this->rawTeam['endedIn'] === '') {
                $this->createFranchiseIfNotExist();
            }

            if (($message = $this->checkIfTeamExist()) !== null) {
                $io->note($message . ' line ' . ($index + 2));
                continue;
            }

            $this->newTeam = new Team();
            $this->newTeam->setName($this->rawTeam['name']);
            $this->newTeam->setTricode($this->rawTeam['tricode']);
            $this->newTeam->setFranchise($this->lastInsertedFranchise);
            $this->newTeam->setSlug(
                $this->slugger->slug(
                    strtolower($this->rawTeam['name'])
                    .' ' .
                    explode(
                        '-',
                        $this->rawTeam['createdIn']
                    )[0]
                )
            );
            $this->newTeam->setConference($this->rawTeam['conference']);
            $this->setSeasons();
            $this->addCompetitions();
            $this->newTeam->setCreatedAt(new \DateTimeImmutable());

            $this->manager->persist($this->newTeam);
            $this->manager->flush();
            $io->success(
                'New team created ' .
                $this->newTeam->getName() .
                ' from ' .
                $this->newTeam->getCreatedIn()->format('Y')
            );
        }
        return Command::SUCCESS;
    }

    private function populateRawTeam(array $teamData): void
    {
        $this->rawTeam['name']      = trim($teamData[0]);
        $this->rawTeam['tricode']   = trim($teamData[1]);
        $this->rawTeam['league']    = trim(strtolower($teamData[2]));
        $this->rawTeam['createdIn'] = trim($teamData[3]);
        $this->rawTeam['endedIn']   = trim($teamData[4]);
        $this->rawTeam['sister']    = trim($teamData[5]);
        $this->rawTeam['conference'] = trim($teamData[6]);
    }

    private function checkIfTeamExist(): ?string
    {
        $teamRepo = $this->manager->getRepository(Team::class);
        $teamExist = $teamRepo->findOneBy([
            'name'      => $this->rawTeam['name'],
            'createdIn' => new \DateTime(explode('-', $this->rawTeam['createdIn'])[0] . '/01/01')
        ]);
        if ($teamExist === null) {
            return null;
        }
        return $this->rawTeam['name'] . ' from ' . $this->rawTeam['createdIn'] . ' already exists';
    }

    private function createFranchiseIfNotExist(): void
    {
        $franchise = $this->manager->getRepository(Franchise::class)->findOneBy(
            [
                'name' => $this->rawTeam['name'],
                'createdIn' => new \DateTime(explode('-', $this->rawTeam['createdIn'])[0] . '/01/01')
            ]
        );
        if (!$franchise) {
            $franchise = new Franchise();
            $franchise
                ->setName($this->rawTeam['name'])
                ->setSlug($this->slugger->slug(strtolower($this->rawTeam['name'])))
                ->setTricode($this->rawTeam['tricode'])
                ->setCreatedIn(new \DateTimeImmutable(explode('-', $this->rawTeam['createdIn'])[0] . '/01/01'))
                ->setCreatedAt(new \DateTimeImmutable());
            $this->manager->persist($franchise);
            $this->manager->flush();
        }
        $this->lastInsertedFranchise = $franchise;
    }

    private function setSeasons(): void
    {
        $this->newTeam->setCreatedIn(new \DateTimeImmutable(explode('-', $this->rawTeam['createdIn'])[0] . '/01/01'));
        if ($this->rawTeam['endedIn'] !== '') {
            $this->newTeam->setEndedIn(
                new \DateTimeImmutable((int) explode('-', $this->rawTeam['endedIn'])[0] + 1 . '/01/01')
            );
        }
    }

    private function addCompetitions(): void
    {
        $endSeason = $this->newTeam->getEndedIn() !== null ? $this->newTeam->getEndedIn() : new \DateTime();
        $seasons = $this->manager->getRepository(Season::class)
            ->findAllMultiSeasonBetween2Years(
                $this->newTeam->getCreatedIn()->format('Y'),
                $endSeason->format('Y')
            );
        $leagues = $this->manager
            ->getRepository(League::class)
            ->findLeaguesFromArrayOfNames(['name' => explode('/', $this->rawTeam['league'])]);

        foreach ($leagues as $league) {
            //for now, we just care about nba we'll see later for include ABA and other leagues
            if ($league->getName() !== 'NBA') {
                continue;
            }
            foreach ($seasons as $season) {
                $competitions = $this->manager->getRepository(Competition::class)
                    ->findAllByLeagueAndSeason($league, $season);
                foreach ($competitions as $competition) {
                    $this->newTeam->addCompetition($competition);
                }
            }
        }
    }
}
