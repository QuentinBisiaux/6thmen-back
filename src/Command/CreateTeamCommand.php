<?php

namespace App\Command;

use App\Entity\Library\League;
use App\Entity\Library\Team;
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

    public function __construct(
        private FileManager $fileManager,
        private SluggerInterface $slugger,
        private EntityManagerInterface $manager,
    )
    {
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

            if (($message = $this->checkIfTeamExist()) !== null) {
                $io->note($message . ' line ' . $index + 2);
                continue;
            }

            $this->newTeam = new Team();
            $this->newTeam->setName($this->rawTeam['name']);
            $this->newTeam->setTricode($this->rawTeam['tricode']);
            $this->newTeam->setSlug($this->rawTeam['slug']);
            $this->newTeam->setConference($this->rawTeam['conference']);

            if (($message = $this->setLeagues()) !== null) {
                $io->error($message);
                continue;
            }

            $this->setSeasons();
            $this->newTeam->setCreatedAt(new \DateTimeImmutable());

            $this->manager->persist($this->newTeam);
            $this->manager->flush();
            $io->success('New team created ' . $this->newTeam->getName() . ' from ' . $this->newTeam->getCreatedIn()->format('Y'));
        }
        return Command::SUCCESS;
    }

    private function populateRawTeam(array $teamData): void
    {
        $this->rawTeam['name']      = trim($teamData[0]);
        $this->rawTeam['tricode']   = trim($teamData[1]);
        $this->rawTeam['slug']      = $this->slugger->slug(strtolower(trim($teamData[0])) .' ' . explode('-', $teamData[3])[0]);
        $this->rawTeam['league']    = trim($teamData[2]);
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
            'createdIn' => new \DateTimeImmutable(explode('-', $this->rawTeam['createdIn'])[0] . '/01/01')
        ]);
        if ($teamExist === null) {
            return null;
        }
        return $this->rawTeam['name'] . ' from ' . $this->rawTeam['createdIn'] . ' already exists';

    }

    private function setLeagues(): ?string
    {
        $leagueRepo = $this->manager->getRepository(League::class);
        foreach (explode('/', $this->rawTeam['league']) as $leagueToFind) {
            $league = $leagueRepo->findOneBy(['name' => trim($leagueToFind)]);
            if (!$league) {
                return 'League ' . $leagueToFind . ' does not exist for team ' . $this->newTeam->getName() . ' with leagues : ' . $this->rawTeam['league'];
            }
            $this->newTeam->setLeague($league);
        }
        return null;
    }

    private function setSeasons(): void
    {
        $this->newTeam->setCreatedIn(new \DateTimeImmutable(explode('-', $this->rawTeam['createdIn'])[0] . '/01/01'));

        if ($this->rawTeam['endedIn'] !== '') {
            $this->newTeam->setEndedIn(new \DateTimeImmutable((int) explode('-', $this->rawTeam['endedIn'])[0] + 1 . '/01/01'));
            if ($this->rawTeam['sister'] !== '') {
                $teamRepo = $this->manager->getRepository(Team::class);
                $teamSister = $teamRepo->findOneBy(['name' => trim($this->rawTeam['sister'])]);
                $this->newTeam->setSisterTeam($teamSister);
            }
        }
    }
}
