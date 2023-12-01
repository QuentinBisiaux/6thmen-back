<?php

namespace App\Http\Api\Controller;

use App\Domain\Auth\JWTAuth;
use App\Domain\Team\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user-profile')]
class UserProfileController extends ApiController
{

    public function __construct
    (
        private JWTAuth $JWTAuth,
        private EntityManagerInterface $entityManager
    )
    {
        parent::__construct($this->JWTAuth);
    }


    #[Route('/data', name: 'api_user_data', methods: ['POST'])]
    public function getUserData(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }
        return $this->json(['user' => $user], 200, [], ['groups' => 'read:user']);
    }

    #[Route('/favorite-team', name: 'api_user_favorite_team', methods: ['POST'])]
    public function manageUserFavoriteTeams(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }
        $userProfile = $user->getProfile();

        $content = $request->getContent();
        $data = json_decode($content, true);
        $this->entityManager->persist($userProfile->cleanAllFavoriteTeams());
        $teams = $this->entityManager->getRepository(Team::class)->findTeamsByIds($data);
        foreach($teams as $team) {
            $this->entityManager->persist($userProfile->addFavoriteTeam($team));
        }
        $this->entityManager->flush();

        return $this->json(['user' => $user], 200, [], ['groups' => 'read:user']);
    }

    #[Route('/delete', name: 'api_user_delete', methods: ['DELETE'])]
    public function deleteUser(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->json([], 204);
    }

}