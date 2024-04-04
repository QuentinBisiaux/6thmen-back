<?php

namespace App\Infrastructure\Context;

use App\Domain\League\Entity\Competition;
use App\Domain\League\Entity\CompetitionType;
use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Domain\League\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;

class Context
{

    private League $league;

    private Season $season;

    private ?Competition $competition = null;

    private array $dates = [];

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function initContext(League $league, Season $season, string $name): void
    {
        $this->league = $league;
        $this->season = $season;
        $competitionRepository = $this->entityManager->getRepository(Competition::class);
        $this->competition = $competitionRepository->findPreciseCompetition($league, $season, $name);
        $this->setUpDate();

    }

    public function getLeague(): League
    {
        return $this->league;
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function getSeason(): Season
    {
        return $this->season;
    }


    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    private function setUpDate(): void
    {

        if (!$this->competition) {
            throw new \InvalidArgumentException(
                'There is no competition for this league : '
                . $this->league->getName() . ' and this season : '
                . $this->season->getYear());
        }

        if($this->competition->getTournaments()->isEmpty()) {
            $this->dates['startAt'] = $this->competition->getStartAt();
            $this->dates['endAt'] = $this->competition->getEndAt();
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