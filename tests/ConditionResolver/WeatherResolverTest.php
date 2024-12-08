<?php

declare(strict_types=1);

namespace App\Tests\ConditionResolver;

use App\Condition\CurrentWeather;
use App\Condition\LastWeather;
use App\ConditionResolver\CurrentWeatherResolver;
use App\ConditionResolver\LastWeatherResolver;
use App\Entity\Weather;
use App\Repository\WeatherRepository;
use App\Tests\DummiesFactory;
use App\Tests\FixtureLoaderCapableTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherResolverTest extends KernelTestCase
{
    use FixtureLoaderCapableTrait;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->loadFixture(new WeatherResolverFixtures());
    }

    public function testItAcceptsCurrentValidWeather(): void
    {
        $resolver = self::getContainer()->get(CurrentWeatherResolver::class);
        $conditionOne = new CurrentWeather(Weather::STATE_SUNNY);
        self::assertTrue($resolver->resolve($conditionOne), 'it fail to valid current weather');
    }

    public function testItRefusesInvalidCurrentWeather(): void
    {
        $resolver = self::getContainer()->get(CurrentWeatherResolver::class);
        $conditionOne = new CurrentWeather(Weather::STATE_RAIN);
        self::assertFalse($resolver->resolve($conditionOne), 'it fail to invalid current weather');
    }

    public function testItAcceptsLastValidWeather(): void
    {
        $resolver = self::getContainer()->get(LastWeatherResolver::class);
        $conditionOne = new LastWeather(Weather::STATE_STORM);
        self::assertTrue($resolver->resolve($conditionOne), 'it fail to valid last weather');
    }

    public function testItRefusesInvalidLastWeather(): void
    {
        $resolver = self::getContainer()->get(LastWeatherResolver::class);
        $conditionOne = new LastWeather(Weather::STATE_CLOUDY);
        self::assertFalse($resolver->resolve($conditionOne), 'it fail to invalid last weather');
    }
}
