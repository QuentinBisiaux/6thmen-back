<?php

namespace App\Http\Api\Controller\Forecast;

use App\Domain\Forecast\Trophy\TrophyForecastService;
use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Trophy;
use App\Http\Api\Controller\ApiController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/forecast/trophy', name: 'forecast_trophy_')]
class TrophyForecastController extends ApiController
{

    #[Route(path: '/{name}/{year}', name: 'show', requirements: ['year' => '\d{4}-\d{2}'], methods: ['GET'])]
    public function index(Request $request, #[MapEntity] League $league, #[MapEntity] Season $season, TrophyForecastService $trophyForecastService): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $this->context->initContext($league, $season, CompetitionType::COMPETITION_REGULAR_SEASON);

        $data = $trophyForecastService->getTrophyForecastData($user->getProfile(), $this->context);

        return $this->json($data,201, [], ['groups' => 'api:read:forecast-trophies']
        );
    }

    #[Route(path: '/{name}/{year}/update/{trophyName}', name: 'update', methods: ['POST'])]
    public function update(Request $request, #[MapEntity] League $league, #[MapEntity] Season $season, string $trophyName, TrophyForecastService $trophyForecastService): JsonResponse
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
            $this->context->initContext($league, $season, CompetitionType::COMPETITION_REGULAR_SEASON);
            $trophy = $this->entityManager->getRepository(Trophy::class)->findOneBy(
                [
                    'name' => $trophyName,
                    'competition' => $this->context->getCompetition()
                ]
            );
            $trophyForecastService->updateForecastTrophy($user->getProfile(), $this->context, $trophy, $data);
            return $this->json([]);
        } catch (\Exception $ex) {
            return $this->json(['error' => 'Erreur lors de l\'enregistrement des données'], 500);
        }
    }

    #[Route(path: '/{name}/{year}/players', name: 'players', methods: ['GET'])]
    public function players(Request $request, #[MapEntity] League $league, #[MapEntity] Season $season, TrophyForecastService $trophyForecastService): JsonResponse
    {
        try {
            $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $this->context->initContext($league, $season, CompetitionType::COMPETITION_REGULAR_SEASON);

        $data = $trophyForecastService->getPlayersData($this->context);
        return $this->json($data, 201, [], ['groups' => 'read:player']);
    }

    private function validateDuplicateRank(?array $data): bool
    {
        if(!isset($data['duplicatePosition']))return true;

        $positionData = $data['duplicatePosition'];

        if (!isset($positionData['trophy'], $positionData['rank']) || isset($positionData['player'])) {
            return false;
        }

        if(!is_array($positionData['trophy']) || !is_int($positionData['trophy']['id']) || !is_string($positionData['trophy']['name']) || !is_string($positionData['trophy']['abbreviation'])) {
            return false;
        }

        if (!is_int($positionData['rank'])) {
            return false;
        }

        if (is_array($positionData['player'])) {
            return false;
        }

        return true;

    }

    private function validateRankData(array $data): bool
    {
        if (!isset($data['trophy'], $data['rank'], $data['player'])) {
            return false;
        }

        if(!is_array($data['trophy']) || !is_int($data['trophy']['id']) || !is_string($data['trophy']['name']) || !is_string($data['trophy']['abbreviation'])) {
            return false;
        }

        if (!is_int($data['rank'])) {
            return false;
        }

        if(!is_array($data['player']) || !is_int($data['player']['id']) || !is_string($data['player']['name'])) {
            return false;
        }

        return true;
    }


}