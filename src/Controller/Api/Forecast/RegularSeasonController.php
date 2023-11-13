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
        private JWTAuth $JWTAuth,
        private EntityManagerInterface $entityManager
    )
    {
        parent::__construct($this->JWTAuth);
    }
    #[Route('/{year}', name: 'api_prono_saison', methods: ['GET'])]
    public function setupUserForecast(Request $request, Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $forecastRegularSeasonRepo = $this->entityManager->getRepository(ForecastRegularSeason::class);
        $forecastRegularSeason = $forecastRegularSeasonRepo->findUserForecastRegularSeason($user, $season);
        if(!empty($prono))  return $this->json($forecastRegularSeason, 200, [], ['groups' => 'api:read:forecast-regular-season']);

        $forecastRegularSeason = new ForecastRegularSeason();
        $forecastRegularSeason->setUser($user)->setSeason($season)->setCreatedAt(new \DateTimeImmutable());
        $forecastCompleted = $this->setUpTeamForNewForecast($forecastRegularSeason);

        $this->entityManager->persist($forecastCompleted);
        $this->entityManager->flush();

        return $this->json($forecastCompleted, 201, [], ['groups' => 'api:read:forecast-regular-season']);

    }

    #[Route('/{year}/update', name: 'api_prono_saison_update', methods: ['POST'])]
    public function updateUserProno(Request $request, Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        $content = $request->getContent();
        $data = json_decode($content, true);

        $pronoSeasonRepo = $this->entityManager->getRepository(ForecastRegularSeason::class);
        /** @var ForecastRegularSeason $prono */
        $prono = $pronoSeasonRepo->findUserPronoForSeason($user, $season);
        if(empty($prono)) return $this->json($prono, 200, [], ['groups' => 'api:read:pronoSeason']);

        $prono->setValid($this->isTotalVictoriesOk($data));
        $prono->setData($data);
        $prono->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($prono);
        $this->entityManager->flush();

        return $this->json(['isComplete' => $prono->isValid()]);
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