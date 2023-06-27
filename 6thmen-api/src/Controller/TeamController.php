<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/team1')]
class TeamController extends AbstractController
{

    public function __construct(
        private TeamRepository $teamRepository
    )
    {}

    #[Route('/rank', name: 'api_team_rank', methods: ['GET'])]
    public function teamsByRankWithOdds(): JsonResponse
    {
        $teams = $this->teamRepository->findTeamsByRankWithOdds();
        return $this->json($teams);
    }

    #[Route('/name', name: 'api_team_name', methods: ['GET'])]
    public function teamsByName(): JsonResponse
    {
        $teams = $this->teamRepository->findTeamsByNameOrdered();
        return $this->json($teams);
    }


}