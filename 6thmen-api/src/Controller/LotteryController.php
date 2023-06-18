<?php

namespace App\Controller;

use App\Entity\Lottery;
use App\Event\LotteryDoneEvent;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lottery')]
class LotteryController extends AbstractController
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    )
    {}
    #[Route('/', name: 'app_lottery', methods: 'POST')]
    public function index(TeamRepository $teamRepository): JsonResponse
    {
        $lottery = new Lottery($teamRepository);
        $results = $lottery->getResults();

        $event = new LotteryDoneEvent($results);
        $this->eventDispatcher->dispatch($event, LotteryDoneEvent::NAME);

        return $this->json($results);

    }
}
