<?php

namespace App\Http\Api\Controller;

use App\Domain\Draft\Lottery\Entity\Lottery;
use App\Domain\Draft\Lottery\Entity\Odds;
use App\Domain\Draft\Lottery\LotteryService;
use App\Domain\League\Entity\Season;
use App\Domain\Standing\StandingDraftService;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/lottery', name: 'lottery_')]
class LotteryController extends AbstractController
{

    #[Route(path: '/{year}', name: 'index', requirements: ['year' => '\d{4}-\d{2}'], methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function index(Season $season, LotteryService $lotteryService): JsonResponse
    {
        return $this->json($lotteryService->getTeamsForLottery($season), 200, [], ['groups' => 'read:lottery']);
    }

    #[Route(path: '/{year}/launch', name: 'launch', requirements: ['year' => '\d{4}-\d{2}'], methods: ['POST'])]
    public function show(Season $season, LotteryService $lotteryService): JsonResponse
    {
        return $this->json($lotteryService->launch($season), 200, [], ['groups' => 'read:lottery']);
    }

}
