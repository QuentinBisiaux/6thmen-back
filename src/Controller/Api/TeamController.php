<?php

namespace App\Controller\Api;

use App\Entity\Library\Team;
use App\Repository\Library\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/team')]
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
        return $this->json($this->teamRepository->actualTeams());
    }

    #[Route('/name', name: 'api_team_name', methods: ['GET'])]
    public function teamsByOrderedByName(): JsonResponse
    {
        $teams = $this->teamRepository->findTeamsByNameOrdered();
        return $this->json($teams);
    }

    #[Route('/{slug}/players', name: 'api_team_players', methods: ['GET'])]
    public function allPlayersFromTeam(Team $team): JsonResponse
    {
        return $this->json($team->getPlayerTeams());
    }


}