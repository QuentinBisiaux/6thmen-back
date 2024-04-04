<?php

namespace App\Tests\Domain\League\Entity;

use App\Domain\League\Entity\Competition;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class CompetitionTest extends KernelTestCase
{
    use FixturesTrait;
    public function getEntity(): Competition
    {
        /** @var Competition $competition */
        ['competition_1' => $competition] = $this->loadFixtures(['competition']);
        return $competition;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNameInCompetitionType()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 2);
        $this->assertHasErrors($this->getEntity()->setName('azerty'), 1);
    }

    public function testCascadeOnLeagueDelete()
    {
        $competition = $this->getEntity();
        $competitionRepository = $this->em->getRepository(Competition::class);
        $competitionId = $competition->getId();
        $league = $competition->getLeague();
        $this->remove($league);
        $this->em->flush();
        $this->em->clear();
        $this->assertEquals(null, $competitionRepository->find($competitionId));
    }

    public function testGamesIsPositiveInteger()
    {
        $this->assertHasErrors($this->getEntity()->setGames(-50), 1);
    }

    public function testEndAtAlwaysAfterThanStartAt()
    {
        $endAt = $this->getEntity()->getStartAt()->modify('-1year');
        $this->assertHasErrors($this->getEntity()->setEndAt($endAt), 1);
    }

    public function testCompetitionIsUniqueByNameLeagueAndSeason()
    {
        $competition = $this->getEntity();
        $competition2 = new Competition();
        $competition2
            ->setName($competition->getName())
            ->setSeason($competition->getSeason())
            ->setLeague($competition->getLeague())
            ->setStartAt($competition->getStartAt())
            ->setEndAt($competition->getEndAt())
            ->setCreatedAt(new \DateTime());
        $this->expectException(UniqueConstraintViolationException::class);
        $this->em->getRepository(Competition::class)->save($competition2, true);
    }


}