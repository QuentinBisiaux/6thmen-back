<?php

namespace App\Controller\Api;

use App\Entity\Api\Lottery;
use App\Entity\Api\Odds;
use App\Entity\Library\Season;
use App\Repository\Library\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lottery')]
class LotteryController extends AbstractController
{
    #[Route('/{year}', name: 'app_lottery', requirements: ['year' => '\d{4}-\d{2}'], methods: ['GET'])]
    public function index(Season $season): JsonResponse
    {
        $standings = $season->getStandings();
        foreach ($standings as $standing) {
            $standing->setOdds(Odds::ODDS[$standing->getRank() - 1]);
        }

        return $this->json($standings, 200, [], ['groups' => 'read:pre-lottery']);
    }

    #[Route('/{year}/launch', name: 'app_lottery_launch', requirements: ['year' => '\d{4}-\d{2}'], methods: ['POST'])]
    public function launch(Season $season): JsonResponse
    {
        $standings = $season->getStandings();
        foreach ($standings as $standing) {
            $standing->setOdds(Odds::ODDS[$standing->getRank() - 1]);
        }
        $lottery = new Lottery($standings);
        $results = $lottery->getResults();

        return $this->json($results, 200, [], ['groups' => 'read:pre-lottery']);
    }
}
