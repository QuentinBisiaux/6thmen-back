<?php

namespace App\Controller\Api;

use App\Entity\Library\Position;
use App\Entity\Library\Team;
use App\Repository\Library\PlayerRepository;
use App\Repository\Library\TeamRepository;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/player/')]
class PlayerController extends AbstractController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository
    )
    {}

    #[Route('name', name: 'api_player_name', methods: ['POST'])]
    public function getByName(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $excludedIds = $data['excludedIds'];
        $players = $this->playerRepository->findPlayersByNameAndWithoutSomeId($name, $excludedIds);
        return $this->json($players, 200, [], ['groups' => 'read:player']);
    }

}