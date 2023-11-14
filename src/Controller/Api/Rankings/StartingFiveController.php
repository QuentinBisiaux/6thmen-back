<?php

namespace App\Controller\Api\Rankings;

use App\Controller\Api\ApiController;
use App\Entity\Library\Position;
use App\Entity\Library\StartingFive;
use App\Entity\Library\Team;
use App\Repository\Library\StartingFiveRepository;
use App\Security\Api\JWTAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rankings/starting-five')]
class StartingFiveController extends ApiController
{

    public function __construct
    (
        private readonly JWTAuth                $JWTAuth,
        private readonly EntityManagerInterface $entityManager,
        private readonly StartingFiveRepository $startingFiveRepository
    )
    {
        parent::__construct($this->JWTAuth);
    }

    #[Route('/', name: 'api_starting_five_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $teams =  $this->entityManager->getRepository(Team::class)->findTeamsByNameOrdered();
        $data = [
            'teams' => $teams,
            'userStatingFive' => $user->getStartingFive()
        ];
        return $this->json($data, 201, [], ['groups' => 'read:team', 'read:user', 'api:read:starting-five']);

    }

    #[Route('/{slug}', name: 'api_starting_five_show', methods: ['GET'])]
    public function show(Request $request, Team $team): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $data = [];

        $currentStartingFive = $this->startingFiveRepository->findStartingFiveForUserAndTeam($user, $team);
        if (empty($currentStartingFive)) {
            $currentStartingFive = new StartingFive();
            $currentStartingFive->setUser($user);
            $currentStartingFive->setTeam($team);
            $currentStartingFive->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($currentStartingFive);
            $this->entityManager->flush();
        }
        $data['startingFive'] = $currentStartingFive;

        $data['teams'] = $this->entityManager->getRepository(Team::class)->findTeamAndSisters($team->getId());
        $players = [];
        foreach($data['teams'] as $team) {
            foreach($team->getPlayerTeams() as $value) {
                $player = $value->getPlayer();
                $positionPlayed = Position::getPositionByAbbreviation($value->getPosition());
                if(array_key_exists($player->getId(), $players)) {
                    $players[$player->getId()]['played'] += 1;
                    if(!in_array($positionPlayed, $players[$player->getId()]['position'])) {
                        $players[$player->getId()]['position'][] = $positionPlayed;
                    }
                } else {
                    $players[$player->getId()]['name']      = $player->getFullName();
                    $players[$player->getId()]['played']    = 1;
                    $players[$player->getId()]['position']  = $positionPlayed;
                }
            }
        }

        arsort($players);
        $playersByPosition = [];
        foreach ($players as $id => $playerProcessed) {
            foreach ($playerProcessed['position'] as $position) {
                $playersByPosition[$position[0]][] = ['id' => $id, 'name' => $playerProcessed['name'], 'played' => $playerProcessed['played']];
            }
        }
        foreach ($playersByPosition as &$position) {
            usort($position, function ($a, $b) {
                if ($a['played'] == $b['played']) {
                    return strcmp($a['name'], $b['name']);
                }
                return $b['played'] - $a['played'];
            });
        }
        $data['players'] = $playersByPosition;
        return $this->json($data, 200, [], ['groups' => 'read:player', 'read:team']);

    }

}