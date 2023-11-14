<?php

namespace App\Service\Rankings;

use App\Entity\Library\Player;
use App\Entity\Library\Position;
use App\Entity\Library\StartingFive;
use App\Entity\Library\Team;
use App\Entity\Library\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class StartingFiveService
{

    public function __construct
    (
        private EntityManagerInterface $entityManager,
    )
    {}

    public function getStartingFiveData(User $user, Team $team): array
    {
        $data = [];
        $data['startingFive']   = $this->findOrCreateStartingFive($user, $team);
        $data['teams']          = $this->entityManager->getRepository(Team::class)->findTeamAndSisters($team->getId());
        $players                = $this->processPlayers($data['teams']);
        $data['players']        = $this->organizePlayersByPosition($players);
        return $data;
    }

    private function findOrCreateStartingFive(User $user, Team $team): StartingFive
    {
        $startingFive = $this->entityManager->getRepository(StartingFive::class)->findStartingFiveForUserAndTeam($user, $team);
        if (is_null($startingFive)) {
            $startingFive = new StartingFive();
            $startingFive->setUser($user);
            $startingFive->setTeam($team);
            $startingFive->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($startingFive);
            $this->entityManager->flush();
        }
        return $startingFive;
    }

    private function processPlayers($teams): array
    {
        $players = [];
        foreach ($teams as $team) {
            foreach ($team->getPlayerTeams() as $value) {
                $player = $value->getPlayer();
                $positionPlayed = Position::getPositionByAbbreviation($value->getPosition());
                if (array_key_exists($player->getId(), $players)) {
                    $players[$player->getId()]['played'] += 1;
                    if (!in_array($positionPlayed, $players[$player->getId()]['position'])) {
                        $players[$player->getId()]['position'][] = $positionPlayed;
                    }
                } else {
                    $players[$player->getId()]['name'] = $player->getFullName();
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

    public function updateStartingFive(StartingFive $startingFive, array $data): bool
    {

        $position = $data['position'];
        $player = $this->entityManager->getRepository(Player::class)->findOneById($data['playerId']);

        switch ($position) {
            case 'Meneur':
                $startingFive->setPointGuard($player);
                break;
            case 'Arriere':
                $startingFive->setGuard($player);
                break;
            case 'Ailier':
                $startingFive->setForward($player);
                break;
            case 'AilierFort':
                $startingFive->setSmallForward($player);
                break;
            case 'Pivot':
                $startingFive->setCenter($player);
                break;
        }
        $startingFive->setValid();
        $startingFive->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->getRepository(StartingFive::class)->save($startingFive);
        $this->entityManager->flush();
        return $startingFive->isValid();
    }

}