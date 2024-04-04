<?php

namespace App\Command;

use App\Domain\League\Entity\Season;
use App\Domain\Player\Entity\Player;
use App\Domain\Player\Entity\PlayerTeam;
use App\Domain\Player\Entity\Position;
use App\Domain\Team\Team;
use App\Service\FileManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Intl\Countries;

#[AsCommand(
    name: 'create:player:team',
    description: 'Add a short description for your command',
)]
class CreatePlayerTeamCommand extends Command
{

    const CONST_PATH_PLAYERS = __DIR__ . '/../../var/data/players/playerTeam.csv';

    private array $rawPlayer;

    private array $cache = [];

    public function __construct(
        private readonly FileManager            $fileManager,
        private readonly EntityManagerInterface $manager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTime = microtime(true);
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
        $teamError      = 0;
        $birthplace     = 0;
        $playerCreated  = 0;
        $totalError     = 0;
        $totalInsert    = 0;
        $totalUpdated   = 0;
        foreach ($fileContent as $playerTeamsData) {
            $explodedData = explode(';', $playerTeamsData);
            $this->populateRawPlayer($explodedData);
            if (is_null($this->rawPlayer['season'])) {
                $io->error('Error Season ' . $playerTeamsData);
                $seasonError++;
                $totalError++;
                continue;
            }
            if (is_null($this->rawPlayer['team'])) {
                $io->error('Error Team ' . $playerTeamsData);
                $teamError++;
                $totalError++;
                continue;
            }
            if (empty($this->rawPlayer['birthplace'])) {
                $io->error('Error Birthplace ' . $playerTeamsData);
                $birthplace++;
                $totalError++;
                continue;
            }

            if (is_null($this->rawPlayer['player'])) {
                $newPlayer = new Player();
                $newPlayer->setName($this->rawPlayer['playerName']);
                $newPlayer->setBirthday($this->rawPlayer['birthday']);
                $newPlayer->setBirthPlace($this->rawPlayer['birthplace']);
                $newPlayer->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($newPlayer);
                $this->manager->flush();
                $this->rawPlayer['player'] = $newPlayer;
                $playerCreated++;
            }


            $playerTeam = $this->isPlayerTeamExist();
            $update = $playerTeam !== null;
            if (!$update) {
                $playerTeam = new PlayerTeam();
            }

            $playerTeam->setSeason($this->rawPlayer['season']);
            $playerTeam->setTeam($this->rawPlayer['team']);
            $playerTeam->setPlayer($this->rawPlayer['player']);
            $playerTeam->setPosition(Position::POSITION_NUMBER_MATRIX[$this->rawPlayer['position']]);
            $playerTeam->setJerseyNumber($this->rawPlayer['jerseyNumber']);
            if ($this->rawPlayer['rookie'] === 'R') {
                $playerTeam->setExperience(0);
            } else {
                $playerTeam->setExperience($this->rawPlayer['rookie']);
            }
            if (!$update) {
                $playerTeam->setCreatedAt(new \DateTimeImmutable());
                $totalInsert++;
            } else {
                $playerTeam->setUpdatedAt(new \DateTimeImmutable());
                $totalUpdated++;
            }
            $this->manager->persist($playerTeam);
        }
        $this->manager->flush();
        $io->comment('Season errors : '     . $seasonError);
        $io->comment('Teams errors : '      . $teamError);
        $io->comment('Birthplace errors : ' . $birthplace);
        $io->comment('Total errors : '      . $totalError);
        $io->comment('Player created : '    . $playerCreated);
        $io->comment('Inserted : '          . $totalInsert);
        $io->comment('Updated : '           . $totalUpdated);
        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        $io->comment("Execution time: " . $duration . " seconds.");

        return Command::SUCCESS;
    }

    private function populateRawPlayer(array $playerData): void
    {

        $this->rawPlayer['season']          = $this->initSeason(trim($playerData[0]));
        $this->rawPlayer['team']            = $this->initTeam(trim($playerData[1]), trim($playerData[0]));
        $this->rawPlayer['jerseyNumber']    = trim($playerData[2]);
        $this->rawPlayer['playerName']      = str_replace(' (TW)', "", trim($playerData[3]));
        $this->rawPlayer['birthday']        = new \DateTimeImmutable(trim($playerData[7]));
        $this->rawPlayer['birthplace']      = $this->initCountry(strtoupper(trim($playerData[8])));
        $this->rawPlayer['player']          = $this->initPlayer();
        $this->rawPlayer['position']        = trim($playerData[4]);
        $this->rawPlayer['rookie']          = trim($playerData[9]);
    }

    private function initSeason(string $year): ?Season
    {
        if (!array_key_exists($year, $this->cache)) {
            $this->cache[$year] = $this->manager->getRepository(Season::class)->findOneBy(['year' => $year]);
        }
        return $this->cache[$year];
    }

    private function initTeam(string $name, string $year): ?Team
    {
        $date = new \DateTimeImmutable(substr($year, 0, 4) . '-01-02');
        return $this->manager->getRepository(Team::class)->findByNameAndDate($name, $date);
    }

    private function initPlayer(): ?Player
    {
        return $this->manager->getRepository(Player::class)->findOneBy(
            [
                'name' =>  $this->rawPlayer['playerName'],
                'birthday' => $this->rawPlayer['birthday']
            ]
        );
    }

    private function initCountry(string $country): string
    {
        if (Countries::exists($country)) {
            return Countries::getName($country);
        } elseif (Countries::alpha3CodeExists($country)) {
            return Countries::getAlpha3Name($country);
        }
        return '';
    }

    private function isPlayerTeamExist(): ?PlayerTeam
    {
        return $this->manager->getRepository(PlayerTeam::class)->findOneBy(
            [
                'season' => $this->rawPlayer['season'],
                'player' => $this->rawPlayer['player'],
                'team'   => $this->rawPlayer['team']
            ]
        );
    }
}
