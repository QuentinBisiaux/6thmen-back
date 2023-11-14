<?php

namespace App\Command;

use App\Entity\Library\Country;
use App\Entity\Library\Player;
use App\Entity\Library\PlayerTeam;
use App\Entity\Library\Season;
use App\Entity\Library\Team;
use App\Service\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsCommand(
    name: 'create:player:team',
    description: 'Add a short description for your command',
)]
class CreatePlayerTeamCommand extends Command
{

    const CONST_PATH_PLAYERS = __DIR__ . '/../../var/data/players/playerTeam.csv';

    private array $rawPlayer;

    private Player $newPlayer;

    private PlayerTeam $newPlayerTeam;

    public function __construct(
        private FileManager $fileManager,
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
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
        $teamError      = 0;
        $birthplace     = 0;
        $playerCreated  = 0;
        $totalError     = 0;
        $totalInsert    = 0;
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
            if (is_null($this->rawPlayer['birthplace'])) {
                $io->error('Error Birthplace ' . $playerTeamsData);
                $birthplace++;
                $totalError++;
                continue;
            }

            if (is_null($this->rawPlayer['player'])) {
                $this->newPlayer = new Player();
                $this->newPlayer->setFirstname($this->rawPlayer['playerFirstname']);
                $this->newPlayer->setLastname($this->rawPlayer['playerLastname']);
                $this->newPlayer->setBirthday($this->rawPlayer['birthday']);
                $this->newPlayer->setBirthPlace($this->rawPlayer['birthplace']);
                $this->newPlayer->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($this->newPlayer);
                $this->manager->flush();
                $this->rawPlayer['player'] = $this->newPlayer;
                $playerCreated++;
            }

            $this->newPlayerTeam = new PlayerTeam();
            $this->newPlayerTeam->setSeason($this->rawPlayer['season']);
            $this->newPlayerTeam->setTeam($this->rawPlayer['team']);
            $this->newPlayerTeam->setPlayer($this->rawPlayer['player']);

            if(!$this->isPlayerTeamExist()) {
                $this->newPlayerTeam->setPosition($this->rawPlayer['position']);
                $this->newPlayerTeam->setJerseyNumber($this->rawPlayer['jerseyNumber']);
                $this->newPlayerTeam->setRookieYear(false);
                if ($this->rawPlayer['rookie'] === 'R') {
                    $this->newPlayerTeam->setRookieYear(true);
                }
                $this->newPlayerTeam->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($this->newPlayerTeam);
                $this->manager->flush();
                $totalInsert++;
            }
        }
        $this->manager->flush();
        $io->comment('Season errors : '     . $seasonError);
        $io->comment('Teams errors : '      . $teamError);
        $io->comment('Birthplace errors : ' . $birthplace);
        $io->comment('Total errors : '      . $totalError);
        $io->comment('Player created : '    . $playerCreated);
        $io->comment('Inserted : '          . $totalInsert);

        return Command::SUCCESS;
    }

    private function populateRawPlayer(array $playerData): void
    {
        $names        = explode(' ', trim($playerData[3]));
        $firstname    = array_shift($names);
        $lastname     = str_replace(' (TW)', "", implode(' ', $names));
        $this->rawPlayer['season']          = $this->initSeason(trim($playerData[0]));
        $this->rawPlayer['team']            = $this->initTeam(trim($playerData[1]), trim($playerData[0]));
        $this->rawPlayer['jerseyNumber']    = trim($playerData[2]);
        $this->rawPlayer['playerFirstname'] = $firstname;
        $this->rawPlayer['playerLastname']  = $lastname;
        $this->rawPlayer['birthday']        = new \DateTimeImmutable(trim($playerData[7]));
        $this->rawPlayer['birthplace']      = $this->initCountry(strtoupper(trim($playerData[8])));
        $this->rawPlayer['player']          = $this->initPlayer();
        $this->rawPlayer['position']        = trim($playerData[4]);
        $this->rawPlayer['rookie']          = trim($playerData[9]);
    }

    private function initSeason(string $year): ?Season
    {
        return $this->manager->getRepository(Season::class)->findOneBy(['year' => $year]);
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
                'firstname' =>  $this->rawPlayer['playerFirstname'],
                'lastname' =>  $this->rawPlayer['playerLastname'],
                'birthday' => $this->rawPlayer['birthday']
            ]);
    }

    private function initCountry(string $country): ?Country
    {
        $countryRepo = $this->manager->getRepository(Country::class);
        $countryAlpha = $countryRepo->findOneBy(['alpha2' => $country]);
        if ($countryAlpha instanceof Country) {
            return $countryAlpha;
        }
        $countryName = $countryRepo->findOneBy(['name' => $country]);
        if ($countryName instanceof Country) {
            return $countryName;
        }
        return null;
    }

    private function isPlayerTeamExist(): bool {
        $playerRepo = $this->manager->getRepository(PlayerTeam::class);
        return $playerRepo->findOneBy(
            [
                'season' => $this->newPlayerTeam->getSeason(),
                'player' => $this->newPlayerTeam->getPlayer(),
                'team'   => $this->newPlayerTeam->getTeam()
            ]
        ) instanceof PlayerTeam;
    }
}
