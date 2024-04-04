<?php

namespace App\Tests\Domain\Standing\Entity;

use App\Domain\Standing\Standing;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class StandingTest extends KernelTestCase
{
    use FixturesTrait;

    public function getEntity(): Standing
    {
        /** @var Standing $standing */
        ['standing_1' => $standing] = $this->loadFixtures(['standing']);
        return $standing;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testRankAlwaysEqualOrSuperiorAtZero()
    {
        $this->assertHasErrors($this->getEntity()->setRank(-5), 1);
    }

    public function testRankCanBeNull()
    {
        $this->assertHasErrors($this->getEntity()->setRank(null), 0);
    }

    public function testRankAlwaysInt()
    {
        $standingTest = $this->getEntity();
        $standingTest->setRank(2.05);
        $this->assertEquals(2, $standingTest->getRank());
    }

    public function testVictoriesAlwaysEqualOrSuperiorAtZero()
    {
        $this->assertHasErrors($this->getEntity()->setVictories(-5), 1);
    }

    public function testVictoriesAlwaysInt()
    {
        $standingTest = $this->getEntity();
        $standingTest->setRank(2.05);
        $this->assertEquals(2, $standingTest->getRank());
    }

    public function testLosesAlwaysEqualOrSuperiorAtZero()
    {
        $this->assertHasErrors($this->getEntity()->setLoses(-5), 1);
    }

    public function testLosesAlwaysInt()
    {
        $standingTest = $this->getEntity();
        $standingTest->setRank(2.05);
        $this->assertEquals(2, $standingTest->getRank());
    }

    public function testUniquenessByTeamAndCompetition()
    {
        $standingTest = $this->getEntity();
        $standingTest2 = new Standing();
        $standingTest2
            ->setTeam($standingTest->getTeam())
            ->setCompetition($standingTest->getCompetition())
            ->setVictories(82)
            ->setLoses(0)
            ->setCreatedAt(new \DateTime());
        $this->expectException(UniqueConstraintViolationException::class);
        $this->em->getRepository(Standing::class)->save($standingTest2, true);
    }

}