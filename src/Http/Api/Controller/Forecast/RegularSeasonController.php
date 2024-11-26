<?php

namespace App\Http\Api\Controller\Forecast;

use App\Domain\Forecast\RegularSeason\Entity\ForecastRegularSeason;
use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\Team\Team;
use App\Http\Api\Controller\ApiController;
use App\Infrastructure\Context\Context;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/forecast/regular-season', name: 'forecast_regular_season_')]
class RegularSeasonController extends ApiController
{


    #[Route(path: '/{name}/{year}', name: 'show', methods: ['GET'])]
    public function show(Request $request, #[MapEntity] League $league, #[MapEntity] Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $this->context->initContext($league, $season, CompetitionType::COMPETITION_REGULAR_SEASON);

        $forecastRegularSeasonRepo = $this->entityManager->getRepository(ForecastRegularSeason::class);
        $forecastRegularSeason = $forecastRegularSeasonRepo->findUserForecastRegularSeason($user, $season, $this->context->getDates());
        if(!empty($forecastRegularSeason))  return $this->json([
            'forecast' => $forecastRegularSeason,
            'context' => $this->context->getDates()
        ],
            201,
            [],
            ['groups' => 'api:read:forecast-regular-season']
        );

        $forecastRegularSeason = new ForecastRegularSeason();
        $forecastRegularSeason->setUser($user)->setSeason($season)->setCreatedAt(new \DateTimeImmutable());
        $forecastCompleted = $this->setUpTeamForNewForecast($forecastRegularSeason);

        $this->entityManager->persist($forecastCompleted);
        $this->entityManager->flush();

        return $this->json(
            [
                'forecast' => $forecastCompleted,
                'context' => $this->context->getDates()
            ],
            201,
            [],
            ['groups' => 'api:read:forecast-regular-season']
        );

    }

    #[Route(path: '/{name}/{year}/update', name: 'update', methods: ['POST'])]
    public function update(Request $request, #[MapEntity] League $league, #[MapEntity] Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        $this->context->initContext($league, $season, CompetitionType::COMPETITION_REGULAR_SEASON);

        $content = $request->getContent();
        $data = json_decode($content, true);

        $forecastRegularSeasonRepo = $this->entityManager->getRepository(ForecastRegularSeason::class);
        /** @var ?ForecastRegularSeason $forecastRegularSeason */
        $forecastRegularSeason = $forecastRegularSeasonRepo->findUserForecastRegularSeason($user, $season, $this->context->getDates());
        if(is_null($forecastRegularSeason)) return $this->json($forecastRegularSeason, 200, [], ['groups' => 'api:read:forecast-regular-season']);

        $forecastRegularSeason->setValid($this->isTotalVictoriesOk($data));
        $forecastRegularSeason->setData($data);
        $forecastRegularSeason->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($forecastRegularSeason);
        $this->entityManager->flush();

        return $this->json(['isComplete' => $forecastRegularSeason->isValid()]);
    }

    private function setUpTeamForNewForecast(ForecastRegularSeason $forecast): ForecastRegularSeason
    {
        $teams = $this->entityManager->getRepository(Team::class)->actualTeamsByConference();

        $teamsByConference = ['east' => [], 'west' => []];
        foreach ($teams as $team) {
            $conference = $team->getConference();
            $teamData = [
                'id'            => $team->getId(),
                'name'          => $team->getName(),
                'slug'          => $team->getSlug(),
                'conference'    => $conference,
                'victories'     => 0,
                'defeats'       => 82,
            ];
            $teamsByConference[lcfirst($conference)][] = $teamData;
        }

        return $forecast->setData($teamsByConference);
    }

    private function isTotalVictoriesOk(array $data): bool
    {
        $totalVictories = 0;
        $expectedVictories = 82 * 30 / 2;
        foreach ($data as $conference) {
            foreach($conference as $forecastLine) {
                $totalVictories += $forecastLine['victories'];
            }
        }
        return $totalVictories === $expectedVictories;
    }

}