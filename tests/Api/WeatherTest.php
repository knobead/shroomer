<?php

declare(strict_types=1);

namespace Api;

use App\Entity\Weather;
use App\Tests\Api\WeatherFixtures;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new WeatherFixtures());
    }

    public function testItListsTheSeventhLastWeather(): void
    {
        $this->client->xmlHttpRequest(Request::METHOD_GET, 'api/weathers');

        $response = $this->client->getResponse();
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $jsonResponse = json_decode($response->getContent(), true);
        self::assertArrayHasKey('hydra:member', $jsonResponse);
        $weather = $jsonResponse['hydra:member'];
        self::assertCount(7, $weather);

        $firstWeather = $weather[0];
        self::assertCount(7, $firstWeather);
        self::assertArrayHasKey('iteration', $firstWeather);
        self::assertArrayHasKey('humidity', $firstWeather);
        self::assertArrayHasKey('minTemperature', $firstWeather);
        self::assertArrayHasKey('maxTemperature', $firstWeather);
        self::assertArrayHasKey('state', $firstWeather);

        self::assertIsInt($firstWeather['iteration']);
        self::assertSame(100, $firstWeather['humidity']);
        self::assertSame(-10, $firstWeather['minTemperature']);
        self::assertSame(10, $firstWeather['maxTemperature']);
        self::assertSame(Weather::STATE_STORM, $firstWeather['state']);

        $lastWeather = $weather[6];
        self::assertCount(7, $lastWeather);
        self::assertArrayHasKey('iteration', $lastWeather);
        self::assertArrayHasKey('humidity', $lastWeather);
        self::assertArrayHasKey('minTemperature', $lastWeather);
        self::assertArrayHasKey('maxTemperature', $lastWeather);
        self::assertArrayHasKey('state', $lastWeather);

        self::assertIsInt($lastWeather['iteration']);
        self::assertSame(0, $lastWeather['humidity']);
        self::assertSame(10, $lastWeather['minTemperature']);
        self::assertSame(30, $lastWeather['maxTemperature']);
        self::assertSame(Weather::STATE_SUNNY, $lastWeather['state']);
    }
}
