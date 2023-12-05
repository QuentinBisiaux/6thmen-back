<?php

namespace App\Http\Api\Controller\Rankings;

use App\Domain\Auth\JWTAuth;
use App\Domain\Ranking\Top100\Top100Service;
use App\Http\Api\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/rankings/top-100', name: 'top_100_')]
class Top100Controller extends ApiController
{

    public function __construct
    (
        private readonly JWTAuth       $JWTAuth,
        private readonly Top100Service $top100Service,
    )
    {
        parent::__construct($this->JWTAuth);
    }

    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $data = $this->top100Service->getTop100Data($user->getProfile());
        return $this->json($data, 200, [], ['groups' => ['read:top-100', 'read:player']]);

    }

    #[Route(path: '/update', name: 'update', methods: ['POST'])]
    public function update(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }
        $data = json_decode($request->getContent(), true);
        if(isset($data['top100'])) {
            if (!$this->validateTop100($data['top100'])) {
                return $this->json(['error' => 'Il y a eu une erreur dans les données envoyées'], 400);
            } else {
                try {
                    $this->top100Service->updateUserTop100Full($user->getProfile(), $data);
                    return $this->json(['message' => 'Top 100 updated successfully'], 200);
                } catch (\Exception $ex) {
                    return $this->json(['error' => 'Erreur lors de l\'enregistrement des données'], 500);
                }
            }
        }

        if (!$this->validateRankData($data['newRank']) || !$this->validateDuplicateRank($data)) {
            return $this->json(['error' => 'Il y a eu une erreur dans les données envoyées'], 400);
        }

        try {
            $this->top100Service->updateUserTop100($user->getProfile(), $data);
            return $this->json(['message' => 'Top 100 updated successfully'], 200);
        } catch (\Exception $ex) {
            return $this->json(['error' => 'Erreur lors de l\'enregistrement des données'], 500);
        }

    }

    private function validateDuplicateRank(?array $data): bool
    {
        if(!isset($data['duplicateRank']))return true;
        $rankData = $data['duplicateRank'];
        if (!is_int($rankData['rank']) || $rankData['rank'] < 1 || $rankData['rank'] > 100) {
            return false;
        }
        if (!isset($rankData['id'], $rankData['rank'])) {
            return false;
        }
        if (is_array($rankData['player']) || isset($rankData['player']['id'])) {
            return false;
        }
        return true;

    }

    private function validateRankData(array $rankData): bool
    {
        if (!isset($rankData['id'], $rankData['rank'], $rankData['player'])) {
            return false;
        }

        if (!is_int($rankData['rank']) || $rankData['rank'] < 1 || $rankData['rank'] > 100) {
            return false;
        }

        if (!is_array($rankData['player']) || !isset($rankData['player']['id'])) {
            return false;
        }

        // Add additional checks as necessary
        return true;
    }

    private function validateTop100(array $top100Array) {
        if(count($top100Array['ranking']) !== 100) return false;
        return true;
    }

}