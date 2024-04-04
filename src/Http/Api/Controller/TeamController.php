<?php

namespace App\Http\Api\Controller;

use App\Domain\Team\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/team', name: 'team_')]
class TeamController extends AbstractController
{
    public function __construct(
        private TeamRepository $teamRepository
    )
    {}

    #[Route(path: '/all', name: 'all', methods: ['GET'])]
    public function allTeams(): JsonResponse
    {
        return $this->json($this->teamRepository->findAll(), 200, [], ['groups' => 'read:team']);
    }

    #[Route(path: '/actual', name: 'all_current', methods: ['GET'])]
    public function actualTeams(): JsonResponse
    {
        return $this->json($this->teamRepository->actualTeams(), 200, [], ['groups' => 'read:team']);
    }

    #[Route(path: '/actual/conference', name: 'all_current_by_conf', methods: ['GET'])]
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

    #[Route(path: '/name', name: 'name', methods: ['GET'])]
    public function teamsByOrderedByName(): JsonResponse
    {
        $teams = $this->teamRepository->findTeamsByNameOrdered();
        return $this->json($teams, 200, [], ['groups' => 'read:team']);
    }

}