<?php

namespace App\Controller\Api\Pronostiques\Season;

use App\Entity\Library\PronoSeason;
use App\Entity\Library\Season;
use App\Entity\Library\Team;
use App\Exception\Api\NoBearerException;
use App\Exception\Api\UserDoesNotExistException;
use App\Security\Api\JWTAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/pronostic/saison', host: 'api.6thmen.com')]
class PronoSeasonController extends AbstractController
{

    public function __construct
    (
        private JWTAuth $JWTAuth,
        private EntityManagerInterface $entityManager
    )
    {}
    #[Route('/{year}', name: 'api_prono_saison', methods: ['GET'])]
    public function setupUserProno(Request $request, Season $season): JsonResponse
    {
        try{
            $user = $this->JWTAuth->getUserFromRequest($request);
        } catch(NoBearerException $bearerException) {
            return $this->json(['error' => $bearerException->getMessage()], 401);
        } catch(UserDoesNotExistException $userException) {
            return $this->json(['error' => $userException->getMessage()], 403);
        }

        $pronoSeasonRepo = $this->entityManager->getRepository(PronoSeason::class);
        $prono = $pronoSeasonRepo->findUserPronoForSeason($user, $season);
        if(!empty($prono))  return $this->json($prono, 200, [], ['groups' => 'api:read:pronoSeason']);

        $prono = new PronoSeason();
        $prono->setUser($user)->setSeason($season)->setCreatedAt(new \DateTimeImmutable());
        $pronoCompleted = $this->setUpTeamForNewProno($prono);

        $this->entityManager->persist($pronoCompleted);
        $this->entityManager->flush();

        return $this->json($pronoCompleted, 201, [], ['groups' => 'api:read:pronoSeason']);

    }

    #[Route('/{year}/update', name: 'api_prono_saison_update', methods: ['POST'])]
    public function updateUserProno(Request $request, Season $season): JsonResponse
    {
        try{
            $user = $this->JWTAuth->getUserFromRequest($request);
        } catch(NoBearerException $bearerException) {
            return $this->json(['error' => $bearerException->getMessage()], 401);
        } catch(UserDoesNotExistException $userException) {
            return $this->json(['error' => $userException->getMessage()], 403);
        }

        $content = $request->getContent();
        $data = json_decode($content, true);

        $pronoSeasonRepo = $this->entityManager->getRepository(PronoSeason::class);
        $prono = $pronoSeasonRepo->findUserPronoForSeason($user, $season)[0];
        if(empty($prono)) return $this->json($prono, 200, [], ['groups' => 'api:read:pronoSeason']);

        $prono->setData($data);
        $prono->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($prono);
        $this->entityManager->flush();

        return $this->json([]);
    }

    private function setUpTeamForNewProno(PronoSeason $prono): PronoSeason
    {
        $teams = $this->entityManager->getRepository(Team::class)->actualTeamsByConference();

        $teamsByConference = ['east' => [], 'west' => []];
        foreach ($teams as $team) {
            $conference = $team->getConference();
            $teamData = [
                'id'            => $team->getId(),
                'name'          => $team->getName(),
                'slug'          => $team->getSlug(),
                'conference'    => $conference,
                'victories'     => 0,
                'defeats'       => 0,
            ];

            if ($conference === 'East') {
                $teamsByConference['east'][] = $teamData;
            } elseif ($conference === 'West') {
                $teamsByConference['west'][] = $teamData;
            }
        }

        return $prono->setData($teamsByConference);
    }

}