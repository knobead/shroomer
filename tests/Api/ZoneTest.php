<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Zone;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new ZoneFixtures());
    }

    public function testItDetailsAZone(): void
    {
        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference(ZoneFixtures::FIRST_ZONE_REFERENCE, Zone::class);
        $this->client->xmlHttpRequest(Request::METHOD_GET, sprintf('/api/zone/%d', $zone->getId()));

        $response = $this->client->getResponse();
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $jsonResponse = json_decode($response->getContent(), true);

        self::assertArrayHasKey('name', $jsonResponse);
        self::assertSame(ZoneFixtures::FIRST_ZONE_REFERENCE, $jsonResponse['name']);

        self::assertArrayNotHasKey('myceliums', $jsonResponse, 'it must not exposed where mycelium is!');
        self::assertArrayHasKey('sporocarps', $jsonResponse, 'it must not exposed where mycelium is!');

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
        self::assertArrayHasKey('dikarya', $firstSporocarp);
        self::assertSame(15, $firstSporocarp['size']);
        self::assertSame(10, $firstSporocarp['age']);
        self::assertSame(false, $firstSporocarp['wormy']);
        self::assertSame(false, $firstSporocarp['eaten']);
        self::assertSame(false, $firstSporocarp['rotten']);
        self::assertSame('boletus edulis', $firstSporocarp['dikarya']);
        self::assertSame(25, $secondSporocarp['size']);
        self::assertSame(20, $secondSporocarp['age']);
        self::assertSame(true, $secondSporocarp['wormy']);
        self::assertSame(true, $secondSporocarp['eaten']);
        self::assertSame(true, $secondSporocarp['rotten']);
        self::assertSame('boletus erythropus', $secondSporocarp['dikarya']);
    }

    public function testItListsZones(): void
    {
        $this->client->xmlHttpRequest(Request::METHOD_GET, 'api/zones');

        $response = $this->client->getResponse();
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $jsonResponse = json_decode($response->getContent(), true);
        self::assertArrayHasKey('hydra:member', $jsonResponse);
        $jsonZones = $jsonResponse['hydra:member'];
        self::assertCount(2, $jsonZones);
    }
}
