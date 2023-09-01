<?php

namespace App\Controller\Api;

use App\Entity\Library\Position;
use App\Entity\Library\Team;
use App\Repository\Library\TeamRepository;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/team', host: 'api.6thmen.com')]
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
        $data['players'] = [];

        foreach ($playerTeams as $playerTeam) {
            foreach($playerTeam as $value) {
                $player = $value->getPlayer();
                if(array_key_exists($player->getFirstName() . ' ' . $player->getLastName(), $data['players'])) {
                    $data['players'][$player->getFirstName() . ' ' . $player->getLastName()]['played'] += 1;
                } else {
                    $data['players'][$player->getFirstName() . ' ' . $player->getLastName()]['played'] = 1;
                    $data['players'][$player->getFirstName() . ' ' . $player->getLastName()]['position'] = [];
                }
                if(!in_array(Position::getPositionByAbbreviation($value->getPosition()), $data['players'][$player->getFirstName() . ' ' . $player->getLastName()]['position']))
                {
                    $data['players'][$player->getFirstName() . ' ' . $player->getLastName()]['position'][] = Position::getPositionByAbbreviation($value->getPosition());
                }
            }
        }
        arsort($data['players']);
        return $this->json($data, 200, [], ['groups' => 'read:player', 'read:team']);
    }

}