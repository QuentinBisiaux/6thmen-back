<?php

namespace App\Http\Api\Controller\Forecast;

use App\Domain\Auth\JWTAuth;
use App\Domain\Forecast\Trophy\Entity\Trophy;
use App\Domain\Forecast\Trophy\TrophyForecastService;
use App\Http\Api\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/forecast/trophy', name: 'forecast_trophy_')]
class TrophyForecastController extends ApiController
{
    public function __construct
    (
        private readonly JWTAuth                $JWTAuth,
        private readonly TrophyForecastService $trophyForecastService
    )
    {
        parent::__construct($this->JWTAuth);
    }

    #[Route(path: '/', name: 'show', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $data = $this->trophyForecastService->getTrophyForecastData($user->getProfile());
        return $this->json($data, 201, [], ['groups' => 'api:read:forecast-trophies']);
    }

    #[Route(path: '/update/{name}', name: 'update', methods: ['POST'])]
    public function update(Request $request, Trophy $trophy): JsonResponse
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
            $completed = $this->trophyForecastService->updateForecastTrophy($user->getProfile(), $trophy, $data);
            return $this->json(['isCompleted' => $completed], 200);
        } catch (\Exception $ex) {
            return $this->json(['error' => 'Erreur lors de l\'enregistrement des données'], 500);
        }
        //$data = $this->trophyForecastService->getTrophyForecastData($user->getProfile());
        return $this->json($data, 201, [], ['groups' => 'api:read:forecast-trophies']);
    }

    #[Route(path: '/players', name: 'players', methods: ['GET'])]
    public function players(Request $request): JsonResponse
    {
        try {
            $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $data = $this->trophyForecastService->getPlayersData();
        return $this->json($data, 201, [], ['groups' => 'read:player']);
    }

    private function validateDuplicateRank(?array $data): bool
    {
        if(!isset($data['duplicatePosition']))return true;

        $positionData = $data['duplicatePosition'];

        if (!isset($positionData['trophy'], $positionData['ranking']) || isset($positionData['player'])) {
            return false;
        }

        if(!is_array($positionData['trophy']) || !is_int($positionData['trophy']['id']) || !is_string($positionData['trophy']['name']) || !is_string($positionData['trophy']['abbreviation'])) {
            return false;
        }

        if (!is_int($positionData['ranking'])) {
            return false;
        }

        if (is_array($positionData['player'])) {
            return false;
        }

        return true;

    }

    private function validateRankData(array $data): bool
    {
        if (!isset($data['trophy'], $data['ranking'], $data['player'])) {
            return false;
        }

        if(!is_array($data['trophy']) || !is_int($data['trophy']['id']) || !is_string($data['trophy']['name']) || !is_string($data['trophy']['abbreviation'])) {
            return false;
        }

        if (!is_int($data['ranking'])) {
            return false;
        }

        if(!is_array($data['player']) || !is_int($data['player']['id']) || !is_string($data['player']['name'])) {
            return false;
        }

        return true;
    }


}