<?php

declare(strict_types=1);

namespace App\Tests\ConditionResolver;

use App\Condition\AverageHumidity;
use App\Condition\CurrentWeather;
use App\Condition\LastWeather;
use App\ConditionResolver\AverageHumidityResolver;
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
        self::assertTrue($resolver->resolve($conditionOne), 'it fail to validate current weather');
    }

    public function testItRefusesInvalidCurrentWeather(): void
    {
        $resolver = self::getContainer()->get(CurrentWeatherResolver::class);
        $conditionOne = new CurrentWeather(Weather::STATE_RAIN);
        self::assertFalse($resolver->resolve($conditionOne), 'it fail to invalidate current weather');
    }

    public function testItAcceptsLastValidWeather(): void
    {
        $resolver = self::getContainer()->get(LastWeatherResolver::class);
        $conditionOne = new LastWeather(Weather::STATE_CLOUDY);
        self::assertTrue($resolver->resolve($conditionOne), 'it fail to validate last weather');
    }

    public function testItRefusesInvalidLastWeather(): void
    {
        $resolver = self::getContainer()->get(LastWeatherResolver::class);
        $conditionOne = new LastWeather(Weather::STATE_STORM);
        self::assertFalse($resolver->resolve($conditionOne), 'it fail to invalidate last weather');
    }

    /**
     * @dataProvider provideItAcceptsValidAverageHumidity
     *
     * @param int $humidity
     * @param int $duration
     *
     * @return void
     */
    public function testItAcceptsValidAverageHumidity(int $humidity, int $duration): void
    {
        $resolver = self::getContainer()->get(AverageHumidityResolver::class);
        $conditionOne = new AverageHumidity(humidity: $humidity, duration: $duration);
        self::assertTrue($resolver->resolve($conditionOne), "it fail to validate average humidity");
    }

    public function provideItAcceptsValidAverageHumidity(): array
    {
        return [
            [20, 2],
            [40, 3],
            [70, 7],
        ];
    }

    /**
     * @dataProvider provideItRefusesInvalidAverageHumidity
     *
     * @param int $humidity
     * @param int $duration
     *
     * @return void
     */
    public function testItRefusesInvalidAverageHumidity(int $humidity, int $duration): void
    {
        $resolver = self::getContainer()->get(AverageHumidityResolver::class);
        $conditionOne = new AverageHumidity(humidity: $humidity, duration: $duration);
        self::assertFalse($resolver->resolve($conditionOne), 'it fail to invalidate average humidity');
    }

    public function provideItRefusesInvalidAverageHumidity(): array
    {
        return [
            [30, 2],
            [60, 3],
            [80, 7],
        ];
    }
}
