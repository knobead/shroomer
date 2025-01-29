<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Tree;
use App\Entity\TreeGenusesEnum;
use App\Entity\User;
use App\Entity\Zone;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TreeTest extends ApiTestCase
{
    use FixtureLoaderCapableTrait;
    use PerformAuthenticateRequestTrait;

    private Client $client;
    private Container $container;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->container = self::getContainer();
        $this->token = '';
        $this->loadFixtureWithContainer(new TreeFixtures(), $this->container);
    }

    public function testItCouldNotATreeToOtherZone()
    {
        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference( TreeFixtures::OTHER_ZONE_REFERENCE, Zone::class);
        $zoneUri = 'api/zone/' . $zone->getId();
        $jsonTree = [
            'size' => 0,
            'age' => 0,
            'genus' => TreeGenusesEnum::GENUS_QUERCUS,
            'zone' => $zoneUri
        ];

        $response = $this->client->request(
            Request::METHOD_POST,
            'api/tree',
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'auth_bearer' => $this->token,
                'json' => $jsonTree
            ],
        );

        self::assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testItCouldAddATree(): void
    {
        $user = $this->fixturesRepository->getReference(TreeFixtures::USER_REFERENCE, User::class);
        $this->authenticateRequest($user);

        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference( TreeFixtures::ZONE_REFERENCE, Zone::class);
        $zoneUri = 'api/zone/' . $zone->getId();
        $jsonTree = [
            'size' => 0,
            'age' => 0,
            'genus' => TreeGenusesEnum::GENUS_QUERCUS,
            'zone' => $zoneUri
        ];

        $response = $this->client->request(
            Request::METHOD_POST,
            'api/tree',
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'auth_bearer' => $this->token,
                'json' => $jsonTree
            ],
        );

        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        $treeRepository = self::getContainer()->get('doctrine')->getRepository(Tree::class);
        $trees = $treeRepository->findAll();
        self::assertCount(2, $trees, 'no tree were added');
        $tree = $trees[1];
        self::assertSame(TreeGenusesEnum::GENUS_QUERCUS, $tree->getGenus());
        self::assertSame(0, $tree->getSize());
        self::assertSame(0, $tree->getAge());
    }
}
