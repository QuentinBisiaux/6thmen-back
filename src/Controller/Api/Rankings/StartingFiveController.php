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
        $startingFive   =  $user->getProfile()->getStartingFive();
        $data = [
            'teams'         => $teams,
            'startingFives' => $startingFive
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
        $data = $this->startingFiveService->getStartingFiveData($user->getProfile(), $team);
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

        $data = json_decode($request->getContent(), true);
        if (!$this->validateRankData($data['newPosition']) || !$this->validateDuplicateRank($data)) {
            return $this->json(['error' => 'Il y a eu une erreur dans les données envoyées'], 400);
        }

        try {
            $completed = $this->startingFiveService->updateStartingFive($user->getProfile(), $team, $data);
            return $this->json(['isCompleted' => $completed], 200);
        } catch (\Exception $ex) {
            dd($ex);
            return $this->json(['error' => 'Erreur lors de l\'enregistrement des données'], 500);
        }
    }

    private function validateDuplicateRank(?array $data): bool
    {
        if(!isset($data['duplicatePosition']))return true;

        $positionData = $data['duplicatePosition'];

        if (!isset($positionData['id'], $positionData['position'])) {
            return false;
        }

        if (!is_string($positionData['position']) || $positionData['position'] === '') {
            return false;
        }

        if (is_array($positionData['player']) || isset($positionData['player']['id'])) {
            return false;
        }

        return true;

    }

    private function validateRankData(array $positionData): bool
    {
        if (!isset($positionData['id'], $positionData['position'], $positionData['player'])) {
            return false;
        }

        if (!is_string($positionData['position']) || $positionData['position'] === '') {
            return false;
        }

        if (!is_array($positionData['player']) || !isset($positionData['player']['id'])) {
            return false;
        }

        return true;
    }

}