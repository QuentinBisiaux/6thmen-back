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

}