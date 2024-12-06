<?php
declare(strict_types=1);

namespace App\Tests\ConditionResolver;

use App\Condition\CurrentWeather;
use App\ConditionResolver\CurrentWeatherResolver;
use App\Entity\Weather;
use App\Repository\WeatherRepository;
use App\Tests\DummiesFactory;
use PHPUnit\Framework\TestCase;

class CurrentWeatherResolverTest extends TestCase
{
    public function testItAcceptsValidWeather(): void
    {
        $weather = DummiesFactory::newWeather();
        $weather->setState(Weather::STATE_STORM);
        $weather->setMinTemperature(10);
        $weather->setMaxTemperature(30);

        $repositoryMock = $this->createMock(WeatherRepository::class);
        $repositoryMock->expects($this->any())
            ->method('findLastWeathers')
            ->willReturn([$weather]);

        $resolver = new CurrentWeatherResolver($repositoryMock);
        $conditionOne = new CurrentWeather(Weather::STATE_STORM);
        self::assertTrue($resolver->resolve($conditionOne), 'it fail to valid current weather');
    }

    public function testItRefusesInvalidWeather(): void
    {
        $weather = DummiesFactory::newWeather();
        $weather->setState(Weather::STATE_STORM);
        $weather->setMinTemperature(10);
        $weather->setMaxTemperature(30);

        $repositoryMock = $this->createMock(WeatherRepository::class);
        $repositoryMock->expects($this->any())
            ->method('findLastWeathers')
            ->willReturn([$weather]);

        $resolver = new CurrentWeatherResolver($repositoryMock);
        $conditionOne = new CurrentWeather(Weather::STATE_RAIN);
        self::assertFalse($resolver->resolve($conditionOne), 'it fail to invalid current weather');
    }
}
