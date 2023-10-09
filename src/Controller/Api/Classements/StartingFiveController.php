<?php

namespace App\Controller\Api\Classements;

use App\Controller\Api\ApiController;
use App\Entity\Library\PronoSeason;
use App\Entity\Library\Team;
use App\Security\Api\JWTAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/ratings/starting-five')]
class StartingFiveController extends ApiController
{

    public function __construct
    (
        private JWTAuth $JWTAuth,
        private EntityManagerInterface $entityManager
    )
    {
        parent::__construct($this->JWTAuth);
    }

    #[Route('/{team}', name: 'api_prono_saison', methods: ['GET'])]
    public function setupUserProno(Request $request, Team $team): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
        }



        $this->entityManager->persist($pronoCompleted);
        $this->entityManager->flush();

        return $this->json($pronoCompleted, 201, [], ['groups' => 'api:read:pronoSeason']);

    }

}