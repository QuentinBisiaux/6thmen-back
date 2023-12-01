<?php

namespace App\Tests\Controller\Admin;

use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Team\Team;
use App\Domain\Team\TeamRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TeamRepository $repository;
    private string $path = '/admin/team/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Team::class);

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByUsername('admin');
        $this->client->loginUser($testUser);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Team index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200, '/admin/team1/ new doesnt responded with 200');

        $this->client->submitForm('Save', [
            'team[name]' => 'Testing',
            'team[victory]' => 82,
            'team[rank]' => 1
        ]);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()), 'No new team inserted');

        self::assertResponseRedirects('/admin/team1/', 303, 'after submit new team doesnt redirect');

    }

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
    }

    public function testEdit(): void
    {
        $fixture = new Team();
        $fixture->setName('My Title');
        $fixture->setVictory(52);
        $fixture->setRank(8);
        $fixture->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'team1[name]' => 'Something New',
            'team1[victory]' => 53,
            'team1[rank]' => 8,
        ]);

        self::assertResponseRedirects('/admin/team1/', 303, 'after submit new team1 doesnt redirect');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame(53, $fixture[0]->getVictory());
        self::assertSame(8, $fixture[0]->getRank());
        self::assertNotNull($fixture[0]->getCreatedAt());
        self::assertNotNull($fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Team();
        $fixture->setName('My Title');
        $fixture->setVictory(8);
        $fixture->setRank(30);
        $fixture->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/admin/team1/');
    }
}
