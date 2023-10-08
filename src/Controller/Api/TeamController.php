<?php

namespace App\Controller\Api;

use App\Entity\Library\Position;
use App\Entity\Library\Team;
use App\Repository\Library\TeamRepository;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/team')]
class TeamController extends AbstractController
{
    public function __construct(
        private TeamRepository $teamRepository
    )
    {}

    #[Route('/all', name: 'api_team_all', methods: ['GET'])]
    public function allTeams(): JsonResponse
    {
        return $this->json($this->teamRepository->findAll(), 200, [], ['groups' => 'read:team']);
    }

    #[Route('/actual', name: 'api_team_all_current', methods: ['GET'])]
    public function actualTeams(): JsonResponse
    {
        return $this->json($this->teamRepository->actualTeams(), 200, [], ['groups' => 'read:team']);
    }

    #[Route('/actual/conference', name: 'api_team_all_current_by_conf', methods: ['GET'])]
    public function actualTeamsByConference(): JsonResponse
    {
        $teams = $this->teamRepository->actualTeamsByConference();

        $teamsByConference = ['East' => [], 'West' => []];
        foreach ($teams as $team) {
            $conference = $team->getConference();

            if ($conference === 'East') {
                $teamsByConference['East'][] = $team;
            } elseif ($conference === 'West') {
                $teamsByConference['West'][] = $team;
            }
        }

        return $this->json($teamsByConference, 200, [], ['groups' => 'read:team']);
    }

    #[Route('/name', name: 'api_team_name', methods: ['GET'])]
    public function teamsByOrderedByName(): JsonResponse
    {
        $teams = $this->teamRepository->findTeamsByNameOrdered();
        return $this->json($teams, 200, [], ['groups' => 'read:team']);
    }

    #[Route('/{slug}/players', name: 'api_team_players', methods: ['GET'])]
    public function allPlayersFromTeam(Team $team): JsonResponse
    {
        $teams = $this->teamRepository->findTeamAndSisters($team->getId());
        $playerTeams = [];
        foreach($teams as $team) {
            $playerTeams[] = $team->getPlayerTeams();
        }

        $data = [];
        $data['teams'] = $teams;
        $players = [];

        foreach ($playerTeams as $playerTeam) {
            foreach($playerTeam as $value) {
                $player = $value->getPlayer();
                if(array_key_exists($player->getId(), $players)) {
                    $players[$player->getId()]['played'] += 1;
                } else {
                    $players[$player->getId()]['name'] = $player->getFullName();
                    $players[$player->getId()]['played'] = 1;
                    $players[$player->getId()]['position'] = [];
                }
                if(!in_array(Position::getPositionByAbbreviation($value->getPosition()), $players[$player->getId()]['position']))
                {
                    $players[$player->getId()]['position'][] = Position::getPositionByAbbreviation($value->getPosition());
                }
            }
        }
        arsort($players);
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
        $data['players'] = $playersByPosition;
        return $this->json($data, 200, [], ['groups' => 'read:player', 'read:team']);
    }

}