<?php

namespace App\Controller\Api\Rankings;

use App\Controller\Api\ApiController;
use App\Security\Api\JWTAuth;
use App\Service\Rankings\Top100Service;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rankings/top-100')]
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

    #[Route('/', name: 'api_top_100_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }

        $data = $this->top100Service->getTop100Data($user->getProfile());
        return $this->json($data, 200, [], ['groups' => ['read:top-100', '']]);

    }

}