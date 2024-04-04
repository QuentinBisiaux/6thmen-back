<?php

namespace App\Tests\Http\Api\Controller;

use App\Domain\League\Entity\League;
use App\Domain\League\Entity\Season;
use App\Tests\ApiTestCase;
use App\Tests\FixturesTrait;

class LotteryControllerTest extends ApiTestCase
{
    use FixturesTrait;

    public function testIndex()
    {
        // Create a mock of the LotteryService
        //$lotteryServiceMock = $this->createMock(LotteryService::class);

        // Create a sample season object or mock
/*        $season = new Season();
        $season->setYear('2023-24');
        $standings;

        // Configure the mock to return expected values
        $expectedTeams = [
            // ... Array of teams or data expected from getTeamsForLottery
        ];
        $lotteryServiceMock->expects($this->once())
            ->method('getTeamsForLottery')
            ->with($this->equalTo($season))
            ->willReturn($expectedTeams);*/
        $data = $this->loadFixtures(['lottery']);

        /** @var Season $season */
        $season = $data['season_1'];

        /** @var League $league */
        $league = $data['nba'];

        // Create a client and make a request
        $crawler = $this->client->request('GET', '/api/lottery/'. $league->getName() . '/' . $season->getYear());
//        dump($this->client->getRequest());
        // Assert the response is 200 OK
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'application/json'));

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        //$this->assertArrayHasKey('key', $responseContent);
    }
/*
    public function testShow(): void
    {
        $fixture = new Team();
        $fixture->setName('My Title');
        $fixture->setVictory(32);
        $fixture->setRank(22);
        $fixture->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200, '/admin/team1/ doesnt responded with 200');
        self::assertPageTitleContains('Team', 'Missing tittle');

        $this->markTestIncomplete();

        // Use assertions to check that the properties are properly displayed.
    }*/

}