<?php

namespace App\Service\Rankings;

use App\Entity\Admin\StartingFiveAggregator;
use App\Entity\Library\Top100;
use App\Entity\Library\UserProfile;
use Doctrine\ORM\EntityManagerInterface;

readonly class Top100Service
{

    public function __construct
    (
        private EntityManagerInterface $entityManager,
    )
    {}

    public function getTop100Data(UserProfile $userProfile): array
    {
        $data = [];
        $data['top100']     = $this->findOrCreateTop100($userProfile);
        $data['players']    = $this->processPlayers();
        return $data;
    }

    private function findOrCreateTop100(UserProfile $userProfile): Top100
    {
        $top100 = $userProfile->getTop100();
        if(!is_null($top100)) {
            return $top100;

        }

        $top100 = new Top100();
        $top100->setUserProfile($userProfile);

        $top100->setRanking(null);
        $top100->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($top100);
//        dd('test');

        $this->entityManager->flush();
        $userProfile->setTop100($top100);
        $this->entityManager->persist($userProfile);
        $this->entityManager->flush();



        return $top100;
    }

    private function processPlayers(): array
    {
        return $this->entityManager->getRepository(StartingFiveAggregator::class)->findAllForTop100();
    }

}