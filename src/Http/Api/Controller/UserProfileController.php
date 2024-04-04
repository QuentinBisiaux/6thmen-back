<?php

namespace App\Http\Api\Controller;

use App\Domain\Auth\JWTAuth;
use App\Domain\Team\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/user-profile', name: 'user_profile_')]
class UserProfileController extends ApiController
{

    #[Route(path: '/data', name: 'data', methods: ['POST'])]
    public function getUserData(Request $request): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }
        return $this->json(['user' => $user], 200, [], ['groups' => 'read:user']);
    }

    #[Route(path: '/favorite-team', name: 'favorite_team', methods: ['POST'])]
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

    #[Route(path: '/delete', name: 'delete', methods: ['DELETE'])]
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