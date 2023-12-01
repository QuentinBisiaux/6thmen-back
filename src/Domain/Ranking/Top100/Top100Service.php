<?php

namespace App\Domain\Ranking\Top100;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Player\Entity\HypeScore;
use App\Domain\Player\Entity\Player;
use App\Domain\Ranking\Top100\Entity\Top100;
use App\Domain\Ranking\Top100\Entity\Top100Player;
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
        $data               = [];
        $data['top100']     = $this->findOrCreateTop100($userProfile);
        $data['players']    = $this->processPlayers($data['top100']);
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
        $top100->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($top100);
        $this->entityManager->flush();

        $this->initTop100Player($top100);

        return $top100;
    }

    private function processPlayers(Top100 $top100): array
    {
        $players = $this->entityManager->getRepository(HypeScore::class)->findAllForTop100();
        $ranking = $top100->getRanking();
        foreach ($ranking as $rank) {
            $player = $rank->getPlayer();
            if($player === null) continue;
            foreach ($players as $playerAlreadySelected) {
                if($playerAlreadySelected instanceof Player) {
                    continue;
                }
                if($playerAlreadySelected['id'] === $player->getId()) {
                    continue 2;
                }
            }
            $players[] = $player;
        }
        return $players;
    }

    private function initTop100Player(Top100 $top100): void
    {
        for($x = 1; $x <= 100; $x++) {
            $top100Player = new Top100Player();
            $top100Player->setTop100($top100);
            $top100Player->setRank($x);
            $top100Player->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($top100Player);
            $top100->addRanking($top100Player);
            $this->entityManager->persist($top100);
        }
        $this->entityManager->flush();
    }

    public function updateUserTop100(UserProfile $userProfile, mixed $data): void
    {
        $top100         = $this->findOrCreateTop100($userProfile);
        $newRank        = $data['newRank'];

        if(isset($data['duplicateRank'])) {
            $duplicatedRank     = $data['duplicateRank'];
            $duplicateEntity    = $this->entityManager->getRepository(Top100Player::class)->findOneBy(['top100' => $top100, 'rank' =>$duplicatedRank['rank']]);
            $duplicateEntity->setPlayer(null);
            $duplicateEntity->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($duplicateEntity);
        }
        $newEntity = $this->entityManager->getRepository(Top100Player::class)->findOneBy(['top100' => $top100, 'rank' => $newRank['rank']]);
        $newPlayer = $this->entityManager->getRepository(Player::class)->findOneBy(['id' => $newRank['player']['id']]);
        if(is_null($newPlayer) || trim($newRank['player']['name']) !== $newPlayer->getName()) {
            throw new \Exception();
        }
        $newEntity->setPlayer($newPlayer);
        $newEntity->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($newEntity);
        $this->entityManager->flush();
    }

}