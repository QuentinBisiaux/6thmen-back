<?php

namespace App\Controller\Api\Forecast;

use App\Controller\Api\ApiController;
use App\Entity\Library\ForecastRegularSeason;
use App\Entity\Library\Season;
use App\Entity\Library\Team;
use App\Security\Api\JWTAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/forecast/regular-season')]
class RegularSeasonController extends ApiController
{

    public function __construct
    (
        private readonly JWTAuth                $JWTAuth,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($this->JWTAuth);
    }
    #[Route('/{year}', name: 'api_forecast_regular_season_show', methods: ['GET'])]
    public function show(Request $request, Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $forecastRegularSeasonRepo = $this->entityManager->getRepository(ForecastRegularSeason::class);
        $forecastRegularSeason = $forecastRegularSeasonRepo->findUserForecastRegularSeason($user, $season);
        if(!empty($forecastRegularSeason))  return $this->json($forecastRegularSeason, 200, [], ['groups' => 'api:read:forecast-regular-season']);

        $forecastRegularSeason = new ForecastRegularSeason();
        $forecastRegularSeason->setUser($user)->setSeason($season)->setCreatedAt(new \DateTimeImmutable());
        $forecastCompleted = $this->setUpTeamForNewForecast($forecastRegularSeason);

        $this->entityManager->persist($forecastCompleted);
        $this->entityManager->flush();

        return $this->json($forecastCompleted, 201, [], ['groups' => 'api:read:forecast-regular-season']);

    }

    #[Route('/{year}/update', name: 'api_forecast_regular_season_update', methods: ['POST'])]
    public function update(Request $request, Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        $content = $request->getContent();
        $data = json_decode($content, true);

        $forecastRegularSeasonRepo = $this->entityManager->getRepository(ForecastRegularSeason::class);
        /** @var ForecastRegularSeason $forecastRegularSeason */
        $forecastRegularSeason = $forecastRegularSeasonRepo->findUserForecastRegularSeason($user, $season);
        if(empty($forecastRegularSeason)) return $this->json($forecastRegularSeason, 200, [], ['groups' => 'api:read:forecast-regular-season']);

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
                'defeats'       => 0,
            ];
            $teamsByConference[lcfirst($conference)][] = $teamData;
        }

        return $forecast->setData($teamsByConference);
    }

    private function isTotalVictoriesOk($data): bool
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