<?php

namespace App\Http\Api\Controller\Rankings;

use App\Domain\Ranking\StartingFive\StartingFiveService;
use App\Domain\Team\Franchise;
use App\Domain\Team\Team;
use App\Http\Api\Controller\ApiController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/rankings/starting-five', name: 'starting_five_')]
class StartingFiveController extends ApiController
{


    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $franchises     =  $this->entityManager->getRepository(Franchise::class)->findByNameOrdered();
        $startingFive   =  $user->getProfile()->getStartingFive();
        $data = [
            'franchises'    => $franchises,
            'startingFives' => $startingFive
        ];
        return $this->json($data, 200, [], ['groups' => ['read:team', 'api:read:starting-five']]);

    }

    #[Route(path: '/{slug}', name: 'show', methods: ['GET'])]
    public function show(Request $request, #[MapEntity] Franchise $franchise, StartingFiveService $startingFiveService): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $data = $startingFiveService->getStartingFiveData($user->getProfile(), $franchise);
        return $this->json($data, 200, [], ['groups' => ['read:player', 'read:team', 'api:read:starting-five']]);

    }

    #[Route(path: '/{slug}/update', name: 'update', methods: ['POST'])]
    public function update(Request $request, #[MapEntity] Franchise $franchise, StartingFiveService $startingFiveService): JsonResponse
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
            $completed = $startingFiveService->updateStartingFive($user->getProfile(), $franchise, $data);
            return $this->json(['isCompleted' => $completed], 200);
        } catch (\Exception $ex) {
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