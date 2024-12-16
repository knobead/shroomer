<?php

declare(strict_types=1);

namespace App\Tests\ConditionResolver;

use App\Entity\WeatherStateEnum;
use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WeatherResolverFixtures extends Fixture
{
    public const LAST_WEATHER_REFERENCE = 'last_weather';
    public const CURRENT_WEATHER_REFERENCE = 'current_weather';


    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $weather = DummiesFactory::newWeather();
            $weather->setState(WeatherStateEnum::STATE_RAIN);
            $weather->setHumidity(100);
            $manager->persist($weather);
        }

        $lastWeather = DummiesFactory::newWeather();
        $lastWeather->setState(WeatherStateEnum::STATE_CLOUDY);
        $lastWeather->setHumidity(50);
        $manager->persist($lastWeather);
        $this->addReference(self::LAST_WEATHER_REFERENCE, $lastWeather);

        $currentWeather = DummiesFactory::newWeather();
        $currentWeather->setState(WeatherStateEnum::STATE_SUNNY);
        $currentWeather->setHumidity(0);
        $manager->persist($currentWeather);
        $this->addReference(self::CURRENT_WEATHER_REFERENCE, $currentWeather);

        $manager->flush();
    }
}
