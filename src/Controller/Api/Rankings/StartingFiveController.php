<?php

namespace App\Controller\Api\Rankings;

use App\Controller\Api\ApiController;
use App\Entity\Library\StartingFive;
use App\Entity\Library\Team;
use App\Security\Api\JWTAuth;
use App\Service\Rankings\StartingFiveService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rankings/starting-five')]
class StartingFiveController extends ApiController
{

    public function __construct
    (
        private readonly JWTAuth                $JWTAuth,
        private readonly EntityManagerInterface $entityManager,
        private readonly StartingFiveService    $startingFiveService
    )
    {
        parent::__construct($this->JWTAuth);
    }

    #[Route('/', name: 'api_starting_five_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $teams          =  $this->entityManager->getRepository(Team::class)->findTeamsByNameOrdered();
        $startingFive   =  $this->entityManager->getRepository(StartingFive::class)->findStartingFiveForUser($user);
        $data = [
            'teams'         => $teams,
            'startingFives'  => $startingFive
        ];
        return $this->json($data, 200, [], ['groups' => ['read:team', 'api:read:starting-five']]);

    }

    #[Route('/{slug}', name: 'api_starting_five_show', methods: ['GET'])]
    public function show(Request $request, Team $team): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $data = $this->startingFiveService->getStartingFiveData($user, $team);
        return $this->json($data, 200, [], ['groups' => ['read:player', 'read:team', 'api:read:starting-five']]);

    }

    #[Route('/{slug}/update', name: 'api_starting_five_update', methods: ['POST'])]
    public function update(Request $request, Team $team): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $startingFive   =  $this->entityManager->getRepository(StartingFive::class)->findStartingFiveForUserAndTeam($user, $team);
        $data = json_decode($request->getContent(), true);
        $completed = $this->startingFiveService->updateStartingFive($startingFive, $data);

        return $this->json(['isCompleted' => $completed]);

    }

}