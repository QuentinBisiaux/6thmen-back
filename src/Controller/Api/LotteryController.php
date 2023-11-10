<?php

namespace App\Controller\Api;

use App\Entity\Api\Lottery;
use App\Entity\Api\Odds;
use App\Entity\Library\Season;
use App\Entity\Library\StandingDraft;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/lottery')]
class LotteryController extends AbstractController
{
    #[Route('/{year}', name: 'app_lottery', requirements: ['year' => '\d{4}-\d{2}'], methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function index(Season $season): JsonResponse
    {
        $standingsDraft = $this->getUpdatedStandingsDraft($season);
        return $this->json($standingsDraft, 200, [], ['groups' => 'read:lottery']);
    }

    #[Route('/{year}/launch', name: 'app_lottery_launch', requirements: ['year' => '\d{4}-\d{2}'], methods: ['POST'])]
    public function launch(Season $season): JsonResponse
    {
        $standingsDraft = $this->getUpdatedStandingsDraft($season);
        $lottery = new Lottery($standingsDraft);
        $results = $lottery->getResults();

        return $this->json($results, 200, [], ['groups' => 'read:lottery']);
    }

    private function getUpdatedStandingsDraft(Season $season): Collection
    {
        $standingsDraft = $season->getStandingDrafts();
        foreach ($standingsDraft as $standingDraft) {
            $standingDraft->setOdds(Odds::ODDS[$standingDraft->getRank() - 1]);
        }
        return $standingsDraft;
    }

}
