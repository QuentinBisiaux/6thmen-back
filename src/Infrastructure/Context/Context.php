<?php

namespace App\Infrastructure\Context;

use App\Domain\League\Entity\Competition;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;

class Context
{

    private League $league;

    private ?Season $season;

    private ?Competition $competition;

    private array $dates = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function initContext(League $league, Season $season): void
    {
        $this->league = $league;
        $this->season = $season;
        $this->competition = $this->entityManager->getRepository(Competition::class)->findPlayingCompetition($this->league, $this->season);
        $this->setUpDate();

    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function getLeague(): League
    {
        return $this->league;
    }

    private function setUpDate(): void
    {

        if (!$this->competition) {
            $this->competition = $this->entityManager->getRepository(Competition::class)->findLastCompetition($this->getLastSeason($this->season), $this->league, 'Regular Season');
            $this->dates['startAt'] = $this->competition->getEndAt();
            $this->dates['endAt'] = new \DateTimeImmutable();
            return;
        }

        /** @var Tournament $tournament */
        foreach($this->competition->getTournaments() as $tournament) {
            $currentDate = new \DateTimeImmutable();
            if($currentDate >= $tournament->getStartAt() && $currentDate <= $tournament->getEndAt()) {
                $this->dates['startAt'] = $tournament->getStartAt();
                $this->dates['endAt'] = $tournament->getEndAt();
                return;
            }
        }
    }

    private function getLastSeason(Season $season): Season
    {
        return $this->entityManager->getRepository(Season::class)->findOneBy(['id' => $season->getId() - 2]);
    }


}