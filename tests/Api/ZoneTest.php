<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\MyceliumGenusEnum;
use App\Entity\User;
use App\Entity\Zone;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneTest extends ApiTestCase
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
        $this->loadFixtureWithContainer(new ZoneFixtures(), $this->container);
    }

    public function testItDetailsAZone(): void
    {
        $user = $this->fixturesRepository->getReference(ZoneFixtures::USER_REFERENCE, User::class);
        $this->authenticateRequest($user);

        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference(ZoneFixtures::FIRST_ZONE_REFERENCE, Zone::class);
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('/api/zone/%d', $zone->getId()),
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'auth_bearer' => $this->token,
            ]
        );

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $jsonResponse = $response->toArray();
        self::assertArrayHasKey('name', $jsonResponse);
        self::assertSame(ZoneFixtures::FIRST_ZONE_REFERENCE, $jsonResponse['name']);

        self::assertArrayNotHasKey('myceliums', $jsonResponse, 'it must not exposed mycelium!');
        self::assertArrayHasKey('sporocarps', $jsonResponse, 'it must exposed sporocarp');
        self::assertArrayHasKey('trees', $jsonResponse, 'it must exposed tree');

        $sporocarps = $jsonResponse['sporocarps'];
        self::assertCount(2, $sporocarps);

        $firstSporocarp = $sporocarps[0];
        $secondSporocarp = $sporocarps[1];
        self::assertCount(9, $firstSporocarp);
        self::assertArrayHasKey('id', $firstSporocarp);
        self::assertArrayHasKey('age', $firstSporocarp);
        self::assertArrayHasKey('size', $firstSporocarp);
        self::assertArrayHasKey('wormy', $firstSporocarp);
        self::assertArrayHasKey('eaten', $firstSporocarp);
        self::assertArrayHasKey('rotten', $firstSporocarp);
        self::assertArrayHasKey('genus', $firstSporocarp);
        self::assertSame(15, $firstSporocarp['size']);
        self::assertSame(10, $firstSporocarp['age']);
        self::assertSame(false, $firstSporocarp['wormy']);
        self::assertSame(false, $firstSporocarp['eaten']);
        self::assertSame(false, $firstSporocarp['rotten']);
        self::assertSame(MyceliumGenusEnum::GENUS_MORCHELLA->value, $firstSporocarp['genus']);
        self::assertSame(25, $secondSporocarp['size']);
        self::assertSame(20, $secondSporocarp['age']);
        self::assertSame(true, $secondSporocarp['wormy']);
        self::assertSame(true, $secondSporocarp['eaten']);
        self::assertSame(true, $secondSporocarp['rotten']);
        self::assertSame(MyceliumGenusEnum::GENUS_MORCHELLA->value, $secondSporocarp['genus']);

        $trees = $jsonResponse['trees'];
        self::assertCount(1, $trees);

        $firstTree = $trees[0];
        self::assertCount(6, $firstTree);
        self::assertArrayHasKey('id', $firstTree);
        self::assertArrayHasKey('age', $firstTree);
        self::assertArrayHasKey('size', $firstTree);
        self::assertArrayHasKey('genus', $firstTree);
    }

    public function testItListsZones(): void
    {
        $user = $this->fixturesRepository->getReference(ZoneFixtures::USER_REFERENCE, User::class);
        $this->authenticateRequest($user);

        $response = $this->client->request(
            Request::METHOD_GET,
            '/api/zones',
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'auth_bearer' => $this->token,
            ]
        );
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $jsonResponse = $response->toArray();
        self::assertArrayHasKey('hydra:member', $jsonResponse);
        $jsonZones = $jsonResponse['hydra:member'];
        self::assertCount(2, $jsonZones);
    }
}
