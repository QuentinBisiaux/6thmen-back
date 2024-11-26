<?php

namespace App\Http\Api\Controller\Draft;

use App\Domain\Draft\Lottery\LotteryService;
use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Http\Api\Controller\ApiController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/lottery', name: 'lottery_')]
class LotteryController extends ApiController
{

    #[Route(path: '/{name}/{year}', name: 'index', requirements: ['year' => '\d{4}-\d{2}'], methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function index(#[MapEntity] League $league, #[MapEntity] Season $season, LotteryService $lotteryService): JsonResponse
    {
        $this->context->initContext($league, $season, CompetitionType::COMPETITION_DRAFT);
        return $this->json($lotteryService->getTeamsForLottery($this->context), 200, [], ['groups' => 'read:lottery']);
    }

    #[Route(path: '/{name}/{year}/launch', name: 'launch', requirements: ['year' => '\d{4}-\d{2}'], methods: ['POST'])]
    public function show(#[MapEntity] League $league, #[MapEntity] Season $season, LotteryService $lotteryService): JsonResponse
    {
        $this->context->initContext($league, $season, CompetitionType::COMPETITION_DRAFT);
        return $this->json($lotteryService->launch($this->context), 200, [], ['groups' => 'read:lottery']);
    }
}
