<?php

namespace App\Http\Api\Controller;

use App\Domain\League\Entity\Season;
use App\Domain\Player\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/player', name: 'player_')]
class PlayerController extends AbstractController
{
    public function __construct(
        private readonly PlayerRepository       $playerRepository,
        private readonly EntityManagerInterface $entityManager,

    )
    {}

    #[Route(path: '/name', name: 'name', methods: ['POST'])]
    public function getByName(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $excludedIds = $data['excludedIds'];
        $players = $this->playerRepository->findPlayersByNameAndWithoutSomeId($name, $excludedIds);
        return $this->json($players, 200, [], ['groups' => 'read:player']);
    }

    #[Route(path: '/actual', name: 'actual', methods: ['POST'])]
    public function getCurrentPlayers(): JsonResponse
    {
        $currentSeason = $this->entityManager->getRepository(Season::class)->findOneByYear('2023-24');
        $players = $this->playerRepository->getCurrentPlayers($currentSeason);
        return $this->json($players, 200, [], ['groups' => 'read:player']);
    }

    #[Route(path: '/rookie', name: 'rookies', methods: ['POST'])]
    public function getCurrentRookies(): JsonResponse
    {
        $currentSeason = $this->entityManager->getRepository(Season::class)->findOneByYear('2023-24');
        $players = $this->playerRepository->getCurrentRookies($currentSeason);
        return $this->json($players, 200, [], ['groups' => 'read:player']);
    }

    #[Route(path: '/more-than-2-years', name: 'more_than_two_years', methods: ['POST'])]
    public function getCurrentPlayersWithMoreThan2Seasons(): JsonResponse
    {
        $currentSeason = $this->entityManager->getRepository(Season::class)->findOneByYear('2023-24');
        $players = $this->playerRepository->getCurrentPlayersWithMoreThan2Seasons($currentSeason);
        return $this->json($players, 200, [], ['groups' => 'read:player']);
    }




}