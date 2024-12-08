<?php

declare(strict_types=1);

namespace App\Tests\Generator\Weather;

use App\Entity\Weather;
use App\Generator\Weather\ChainWeatherGenerator;
use App\Generator\Weather\WeatherGeneratorInterface;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherGeneratorTest extends KernelTestCase
{
    /**
     * @dataProvider provideItGeneratesSunnyWeather
     *
     * @param string $type
     *
     * @return void
     */
    public function testItGeneratesWeathers(string $type, int $humidity): void
    {
        self::bootKernel();
        /** @var WeatherGeneratorInterface $generator */
        $generator = self::getContainer()->get(ChainWeatherGenerator::class);
        $generator->generate($type);

        $weatherRepository = self::getContainer()->get(WeatherRepository::class);
        $weathers = $weatherRepository->findLastWeathers(1);

        self::assertCount(1, $weathers);
        $weather = $weathers[0];
        self::assertSame($type, $weather->getState());
        self::assertSame($humidity, $weather->getHumidity());
    }

    private function provideItGeneratesSunnyWeather(): array
    {
        return [[Weather::STATE_SUNNY, 0], [Weather::STATE_RAIN, 100], [Weather::STATE_STORM, 100], [Weather::STATE_CLOUDY, 50]];
    }
}
