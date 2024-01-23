<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class ApiTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    final public const DEFAULT_OPTIONS = [
        'auth_basic' => null,
        'auth_bearer' => null,
        'query' => [],
        'headers' => [
            'accept' => ['application/json'],
            'content-type' => ['application/json'],
        ],
        'body' => '',
        'json' => null,
    ];
    protected KernelBrowser $client;

    protected EntityManagerInterface $em;

    public function setUp(): void
    {
        parent::setUp();

        $server['HTTP_HOST'] = 'localhost:803';

        $this->client = self::createClient(self::DEFAULT_OPTIONS, $server);
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        $this->em = $em;
        $this->em->getConnection()->getConfiguration()->setMiddlewares([]);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->em->clear();
        parent::tearDown();
    }

    public function jsonRequest(string $method, string $url, ?array $data = null): string
    {
        $this->client->request($method, $url, [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ], $data ? json_encode($data, JSON_THROW_ON_ERROR) : null);

        return $this->client->getResponse()->getContent();
    }

}