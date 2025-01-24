<?php

declare(strict_types=1);

namespace App\Tests\Generator\Weather;

use App\Entity\WeatherStateEnum;
use App\Generator\Weather\ChainWeatherGenerator;
use App\Generator\Weather\WeatherGeneratorInterface;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherGeneratorTest extends KernelTestCase
{
    /**
     * @dataProvider provideItGeneratesWeathers
     *
     * @param WeatherStateEnum $type
     * @param int    $humidity
     *
     * @return void
     */
    public function testItGeneratesWeathers(WeatherStateEnum $type, int $humidity): void
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

    /**
     * @return array[]
     */
    private function provideItGeneratesWeathers(): array
    {
        return [
            [WeatherStateEnum::STATE_SUNNY, 0],
            [WeatherStateEnum::STATE_RAIN, 100],
            [WeatherStateEnum::STATE_STORM, 100],
            [WeatherStateEnum::STATE_CLOUDY, 50]
        ];
    }
}
