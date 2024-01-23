<?php

namespace App\Domain\Ranking\StratingFive;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Player\Entity\Player;
use App\Domain\Player\Entity\PlayerTeam;
use App\Domain\Player\Entity\Position;
use App\Domain\Ranking\StratingFive\Entity\StartingFive;
use App\Domain\Ranking\StratingFive\Entity\StartingFivePlayer;
use App\Domain\Team\Team;
use Doctrine\ORM\EntityManagerInterface;

readonly class StartingFiveService
{

    public function __construct
    (
        private EntityManagerInterface $entityManager,
    )
    {}

    public function getStartingFiveData(UserProfile $user, Team $team): array
    {
        $data = [];
        $data['team']           = $team;
        $data['startingFive']   = $this->findOrCreateStartingFive($user, $team);
        $teams                  = $this->entityManager->getRepository(Team::class)->findTeamAndSisters($team->getId());
        $players                = $this->processPlayers($teams);
        $data['players']        = $this->organizePlayersByPosition($players);
        return $data;
    }

    private function findOrCreateStartingFive(UserProfile $user, Team $team): StartingFive
    {
        $startingFive = $this->entityManager->getRepository(StartingFive::class)->findStartingFiveForUserAndTeam($user, $team);
        if (is_null($startingFive)) {
            $startingFive = new StartingFive();
            $startingFive->setUser($user);
            $startingFive->setTeam($team);
            $startingFive->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($startingFive);
            $this->entityManager->flush();

            foreach (Position::BASE_POSITION_BY_NUMBER as $index => $position) {
                $startingFivePlayer = new StartingFivePlayer();
                $startingFivePlayer->setStartingFive($startingFive);
                $startingFivePlayer->setPosition($position);
                $startingFivePlayer->setCreatedAt(new \DateTimeImmutable());
                $this->entityManager->persist($startingFivePlayer);
                $startingFive->addRanking($startingFivePlayer);
                $this->entityManager->persist($startingFive);

            }
            $this->entityManager->flush();

        }
        return $startingFive;
    }

    /** @param Team[] $teams */
    private function processPlayers(array $teams): array
    {
        $players = [];
        foreach ($teams as $team) {
            /** @var PlayerTeam $value */
            foreach ($team->getPlayerTeams() as $value) {
                $player = $value->getPlayer();
                $positionPlayed = Position::getPositionByAbbreviation($value->getPosition());
                if (array_key_exists($player->getId(), $players)) {
                    $players[$player->getId()]['played'] += 1;
                    if (!in_array($positionPlayed, $players[$player->getId()]['position'])) {
                        $players[$player->getId()]['position'][] = $positionPlayed;
                    }
                } else {
                    $players[$player->getId()]['name'] = $player->getName();
                    $players[$player->getId()]['played'] = 1;
                    $players[$player->getId()]['position'] = [$positionPlayed];
                }
            }
        }
        arsort($players);
        return $players;
    }

    private function organizePlayersByPosition(array $players): array
    {
        $playersByPosition = [];
        foreach ($players as $id => $playerProcessed) {
            foreach ($playerProcessed['position'] as $position) {
                $playersByPosition[$position[0]][] = ['id' => $id, 'name' => $playerProcessed['name'], 'played' => $playerProcessed['played']];
            }
        }
        foreach ($playersByPosition as &$position) {
            usort($position, function ($a, $b) {
                if ($a['played'] == $b['played']) {
                    return strcmp($a['name'], $b['name']);
                }
                return $b['played'] - $a['played'];
            });
        }
        return $playersByPosition;
    }

    public function updateStartingFive(UserProfile $userProfile, Team $team, mixed $data): bool
    {
        $startingFive   = $this->findOrCreateStartingFive($userProfile, $team);
        $newPosition    = $data['newPosition'];

        if(isset($data['duplicatePosition'])) {
            $duplicatedPosition = $data['duplicatePosition'];
            $duplicateEntity    = $this->entityManager->getRepository(StartingFivePlayer::class)->findOneBy(
                [
                    'startingFive'  => $startingFive,
                    'position'      => Position::NUMBER_POSITION_BY_POSITION[$duplicatedPosition['position']]
                ]
            );
            $duplicateEntity->setPlayer(null);
            $duplicateEntity->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($duplicateEntity);
        }
        $newEntity = $this->entityManager->getRepository(StartingFivePlayer::class)->findOneBy(
            [
                'startingFive'  => $startingFive,
                'position'      => Position::NUMBER_POSITION_BY_POSITION[$newPosition['position']]
            ]
        );
        $newPlayer = $this->entityManager->getRepository(Player::class)->findOneBy(['id' => $newPosition['player']['id']]);
        if(is_null($newPlayer) || trim($newPosition['player']['name']) !== $newPlayer->getName()) {
            throw new \Exception();
        }
        $newEntity->setPlayer($newPlayer);
        $newEntity->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($newEntity);

        $this->entityManager->flush();

        return $this->isRankingCompleted($startingFive);
    }

    private function isRankingCompleted(StartingFive $startingFive): bool
    {
        foreach ($startingFive->getRanking() as $rank) {
            if ($rank->getPlayer() === null) {
                $startingFive->setValid(false);
                $this->entityManager->persist($startingFive);
                $this->entityManager->flush();
                return false;
            }
        }
        $startingFive->setValid(true);
        $this->entityManager->persist($startingFive);
        $this->entityManager->flush();
        return true;
    }

}