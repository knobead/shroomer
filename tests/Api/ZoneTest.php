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
        $zone = $this->fixturesRepository->getReference(ZoneFixtures::FIRST_GARDEN_REFERENCE, Zone::class);
        $this->client->xmlHttpRequest(Request::METHOD_GET, sprintf('/api/zones/%d', $zone->getId()));

        $response = $this->client->getResponse();
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $jsonResponse = json_decode($response->getContent(), true);
        self::assertArrayHasKey('name', $jsonResponse);
        self::assertSame(ZoneFixtures::FIRST_GARDEN_REFERENCE, $jsonResponse['name']);
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
