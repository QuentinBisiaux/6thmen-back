<?php

namespace App\Controller\Api\Pronostiques\Season;

use App\Controller\Api\ApiController;
use App\Entity\Library\PronoSeason;
use App\Entity\Library\Season;
use App\Entity\Library\Team;
use App\Security\Api\JWTAuth;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/pronostic/saison')]
class PronoSeasonController extends ApiController
{

    public function __construct
    (
        private JWTAuth $JWTAuth,
        private EntityManagerInterface $entityManager
    )
    {
        parent::__construct($this->JWTAuth);
    }
    #[Route('/{year}', name: 'api_prono_saison', methods: ['GET'])]
    public function setupUserProno(Request $request, Season $season): JsonResponse
    {
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage(), 'connected' => false], $ex->getCode());
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
        try {
            $user = $this->tryToConnectUser($request);
        } catch (\Exception $ex) {
            return $this->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        $content = $request->getContent();
        $data = json_decode($content, true);

        $pronoSeasonRepo = $this->entityManager->getRepository(PronoSeason::class);
        /** @var PronoSeason $prono */
        $prono = $pronoSeasonRepo->findUserPronoForSeason($user, $season);
        if(empty($prono)) return $this->json($prono, 200, [], ['groups' => 'api:read:pronoSeason']);

        $prono->setValid($this->isTotalVictoriesOk($data));
        $prono->setData($data);
        $prono->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($prono);
        $this->entityManager->flush();

        return $this->json(['isComplete' => $prono->isValid()]);
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
            $teamsByConference[lcfirst($conference)][] = $teamData;
        }

        return $prono->setData($teamsByConference);
    }

    private function isTotalVictoriesOk($data): bool
    {
        $totalVictories = 0;
        $expectedVictories = 82 * 30 / 2;
        foreach ($data as $conference) {
            foreach($conference as $pronoLine) {
                $totalVictories += $pronoLine['victories'];
            }
        }
        return $totalVictories === $expectedVictories;
    }

}