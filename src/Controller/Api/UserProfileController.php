<?php

namespace App\Controller\Api;

use App\Entity\Library\Team;
use App\Exception\Api\NoBearerException;
use App\Exception\Api\UserDoesNotExistException;
use App\Security\Api\JWTAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user-profile')]
class UserProfileController extends AbstractController
{

    public function __construct
    (
        private JWTAuth $JWTAuth,
        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/data', name: 'api_user_data', methods: ['POST'])]
    public function getUserData(Request $request): JsonResponse
    {
        try {
            $user = $this->JWTAuth->getUserFromRequest($request);
        } catch (NoBearerException $bearerException) {
            return $this->json(['error' => $bearerException->getMessage()], 401);
        } catch (UserDoesNotExistException $userException) {
            return $this->json(['error' => $userException->getMessage()], 403);
        }

        return $this->json(['user' => $user], 200, [], ['groups' => 'read:user']);
    }

    #[Route('/favorite-team', name: 'api_favorite_team', methods: ['POST'])]
    public function manageUserFavoriteTeams(Request $request): JsonResponse
    {
        try{
           $user        = $this->JWTAuth->getUserFromRequest($request);
           $userProfile = $user->getProfile();
        } catch(NoBearerException $bearerException) {
            return $this->json(['error' => $bearerException->getMessage()], 401);
        } catch(UserDoesNotExistException $userException) {
            return $this->json(['error' => $userException->getMessage()], 403);
        }

        $content = $request->getContent();
        $data = json_decode($content, true);
        foreach($userProfile->getFavoriteTeams() as $team) {
            $userProfile->removeFavoriteTeam($team);
            $this->entityManager->persist($userProfile);
        }
        $teams = $this->entityManager->getRepository(Team::class)->findTeamsByIds($data);
        foreach($teams as $team) {
            $userProfile->addFavoriteTeam($team);
            $this->entityManager->persist($userProfile);
        }
        $this->entityManager->flush();

        return $this->json([]);
    }

}