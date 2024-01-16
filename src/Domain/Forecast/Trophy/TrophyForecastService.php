<?php

namespace App\Domain\Forecast\Trophy;

use App\Domain\Auth\Entity\UserProfile;
use App\Domain\Forecast\Trophy\Entity\Trophy;
use App\Domain\Forecast\Trophy\Entity\TrophyForecast;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\Player\Entity\Player;
use App\Infrastructure\Context\Context;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class TrophyForecastService
{
    public function __construct
    (
        private EntityManagerInterface $entityManager,
    )
    {}

    public function getTrophyForecastData(UserProfile $userProfile, Context $context): array
    {
        $data                       = [];
        $data['trophiesForecast']   = $this->organiseDataForForecast($userProfile, $context);
        return $data;
    }

    private function organiseDataForForecast(UserProfile $userProfile, Context $context): array
    {
        $trophiesForecast = $this->findOrCreateTrophyForecast($userProfile, $context);
        $organisedData = [];
        foreach ($trophiesForecast as $trophyForecast) {
            if(!array_key_exists($trophyForecast->getTrophy()->getKey(), $organisedData)) $organisedData[$trophyForecast->getTrophy()->getKey()] = [];
            $organisedData[$trophyForecast->getTrophy()->getKey()][] = $trophyForecast;
        }
        return $organisedData;
    }

    private function findOrCreateTrophyForecast(UserProfile $userProfile, Context $context): Collection
    {
        $trophiesForecast = $userProfile->getTrophiesForecast();
        if($trophiesForecast->count() !== 0) {
            return $trophiesForecast;
        }
        $trophies = $context->getLeague()->getTrophies();
        foreach($trophies as $trophy) {
            $trophyForecasts = $this->entityManager->getRepository(TrophyForecast::class)->findUserTrophyForecast($userProfile, $trophy, $context->getDates());
            if(empty($trophyForecasts)) {

            }
            for($x = 1; $x <= 5; $x++) {
                $trophyForecast = new TrophyForecast();
                $trophyForecast ->setUserProfile($userProfile)
                                ->setRank($x)
                                ->setTrophy($trophy)
                                ->setSeason($context->getSeason())
                                ->setCreatedAt(new \DateTimeImmutable());
                $this->entityManager->persist($trophyForecast);
                $userProfile->addTrophyForecast($trophyForecast);
            }
        }
        $this->entityManager->flush();
        return $userProfile->getTrophiesForecast();
    }

    public function getPlayersData(): array
    {
        $league = $this->entityManager->getRepository(League::class)->findOneByName('NBA');
        $trophies = $league->getTrophies();
        $currentSeason = $this->entityManager->getRepository(Season::class)->findOneByYear('2023-24');
        $players = [];
        $currentPlayers = $this->entityManager->getRepository(Player::class)->getCurrentPlayers($currentSeason);
        foreach($trophies as $trophy) {
            if(!array_key_exists($trophy->getKey(), $players)) $players[$trophy->getKey()] = [];
            switch ($trophy->getAbbreviation()) {
                case 'MVP':
                case 'DPOY':
                case null:
                    $players[$trophy->getKey()] = $currentPlayers;
                    break;
                case 'ROY':
                    $players[$trophy->getKey()] = $this->entityManager->getRepository(Player::class)->getCurrentRookies($currentSeason);
                    break;
                case 'MIP':
                    $players[$trophy->getKey()] = $this->entityManager->getRepository(Player::class)->getCurrentPlayersWithMoreThan2Seasons($currentSeason);
                    break;
            }
        }
        return $players;
    }

    public function updateForecastTrophy(UserProfile $userProfile, Trophy $trophy, array $data): void
    {
        $forecastsTrophy = $this->entityManager->getRepository(TrophyForecast::class)->findUserTrophyForecast($userProfile, $trophy);
        foreach ($forecastsTrophy as $forecastTrophy) {
            if(isset($data["duplicatePosition"]) && $data["duplicatePosition"]['rank'] === $forecastTrophy->getRank()) {
                $forecastTrophy->setPlayer(null);
                $this->entityManager->persist($forecastTrophy);
                continue;
            }
            if($data["newPosition"]['rank'] === $forecastTrophy->getRank()) {
                $newPlayer = $this->entityManager->getRepository(Player::class)->findOneBy(['id' => $data['newPosition']['player']['id']]);
                $forecastTrophy->setPlayer($newPlayer);
                $this->entityManager->persist($forecastTrophy);
            }
        }
        $this->entityManager->flush();
    }

}