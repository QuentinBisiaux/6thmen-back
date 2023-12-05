<?php

namespace App\Http\Api\Controller;

use App\Domain\Player\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/player', name: 'player_')]
class PlayerController extends AbstractController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository
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

}