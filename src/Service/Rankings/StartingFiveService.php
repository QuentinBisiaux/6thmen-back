<?php

namespace App\Service\Rankings;

use App\Entity\Library\Position;
use App\Entity\Library\StartingFive;
use App\Entity\Library\Team;
use App\Entity\Library\User;
use App\Repository\Library\StartingFiveRepository;
use Doctrine\ORM\EntityManagerInterface;

class StartingFiveService
{

    public function __construct
    (
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    public function getStartingFiveData(User $user, Team $team): array
    {
        $currentStartingFive = $this->entityManager->getRepository(StartingFive::class)->findStartingFiveForUserAndTeam($user, $team);

        if (empty($currentStartingFive)) {
            $currentStartingFive = new StartingFive();
            $currentStartingFive->setUser($user);
            $currentStartingFive->setTeam($team);
            $currentStartingFive->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($currentStartingFive);
            $this->entityManager->flush();
        }

        $data = [];
        $data['startingFive']   = $currentStartingFive;
        $data['teams']          = $this->entityManager->getRepository(Team::class)->findTeamAndSisters($team->getId());
        $players                = $this->processPlayers($data['teams']);
        $data['players']        = $this->organizePlayersByPosition($players);
        return $data;
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

}