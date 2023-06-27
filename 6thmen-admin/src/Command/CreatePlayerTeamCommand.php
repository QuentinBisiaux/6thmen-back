<?php

namespace App\Command;

use App\Domain\Player\Player;
use App\Domain\PlayerTeams;
use App\Domain\Season;
use App\Domain\Status;
use App\Domain\Team;
use App\Service\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsCommand(
    name: 'create:player-team1',
    description: 'Add a short description for your command',
)]
class CreatePlayerTeamCommand extends Command
{

    const CONST_PATH_PLAYERS = __DIR__ . '/../../var/data/players/playerTeams.csv';

    public function __construct(
        private FileManager $fileManager,
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $fileContent = $this->fileManager->getFileContent(self::CONST_PATH_PLAYERS);
        } catch (FileException $ex) {
            $io->error($ex->getMessage());
        }
        if (empty($fileContent)) {
            $io->error('No data to process');
            return Command::FAILURE;
        }

        array_shift($fileContent);
        $seasonError    = 0;
        $playerCreated  = 0;
        $birthdayError  = 0;
        $teamError      = 0;
        $totalError     = 0;
        $totalInsert    = 0;
        foreach ($fileContent as $playerTeamsData) {
            $playerTeamsDataArray = explode(';', $playerTeamsData);

            $seasonRepo     = $this->manager->getRepository(Season::class);
            $season         = $seasonRepo->findOneBy(['year' => $playerTeamsDataArray[0]]);
            if (!$season) {
                $io->error('Error Season ' . $playerTeamsData);
                $seasonError++;
                $totalError++;
                continue;
            }

            $player = $this->checkIfPlayerExistAndReturnIt($playerTeamsDataArray);
            if (!$player) {
                $command = $this->getApplication()->find('create:player');
                $arguments = ['line' => $playerTeamsData];
                $greetInput = new ArrayInput($arguments);
                $command->run($greetInput, $output);
                $playerCreated++;
                $player = $this->checkIfPlayerExistAndReturnIt($playerTeamsDataArray);
            }

            $teamRepo   = $this->manager->getRepository(Team::class);
            $team       = $teamRepo->findOneBy(['name' => $playerTeamsDataArray[1]]);
            if (!$team) {
                $io->error('Erreur Team');
                $io->comment($playerTeamsData);
                $teamError++;
                $totalError++;
                continue;
            }

            $playerTeams = new PlayerTeams();
            $playerTeams->setSeason($season);
            $playerTeams->setPlayer($player);
            $playerTeams->setTeam($team);

            if(!$this->isPlayerTeamExist($playerTeams)) {
                $playerTeams->setPosition($playerTeamsDataArray[4]);
                $playerTeams->setJerseyNumber($playerTeamsDataArray[2]);
                $playerTeams->setRookieYear(false);
                if ($playerTeamsDataArray[9] === 'R') {
                    $playerTeams->setRookieYear(true);
                }
                $playerTeams->setStatus(Status::DRAFT);
                $playerTeams->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($playerTeams);
                $totalInsert++;
            }
        }
        $this->manager->flush();
        $io->comment('Season errors : '     . $seasonError);
        $io->comment('Teams errors : '      . $teamError);
        $io->comment('Total errors : '      . $totalError);
        $io->comment('Birthday errors : '   . $birthdayError);
        $io->comment('Player created : '   . $playerCreated);
        $io->comment('Inserted : '          . $totalInsert);

        return Command::SUCCESS;
    }

    private function checkIfPlayerExistAndReturnIt(array $playerTeamsDataArray): ?Player {
        $names = explode(' ', $playerTeamsDataArray[3]);
        $playerFirstname    = array_shift($names);
        $playerLastname     = implode(' ', $names);
        $playerRepo         = $this->manager->getRepository(Player::class);
        return $playerRepo->findOneBy(
            [
                'firstname' => $playerFirstname,
                'lastname'  => $playerLastname,
                'birthday'  => new \DateTimeImmutable($playerTeamsDataArray[7])
            ]
        );
    }

    private function isPlayerTeamExist(PlayerTeams $playerTeams): bool {
        $playerRepo = $this->manager->getRepository(PlayerTeams::class);
        $fetched    = $playerRepo->findOneBy(
            [
                'season' => $playerTeams->getSeason(),
                'player' => $playerTeams->getPlayer(),
                'team1'   => $playerTeams->getTeam()
            ]
        );
        return $fetched instanceof PlayerTeams;
    }
}
