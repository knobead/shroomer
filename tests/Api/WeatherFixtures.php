<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Weather;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class WeatherFixtures extends Fixture
{
    public const string WEATHER_REFERENCE_PATTERN  = 'weather_%d';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 15; $i++) {
            $weather = DummiesFactory::newWeather();
            $this->addReference(sprintf(self::WEATHER_REFERENCE_PATTERN, $i), $weather);
            $manager->persist($weather);
        }

        $weather->setHumidity(100);
        $weather->setMinTemperature(-10);
        $weather->setMaxTemperature(10);
        $weather->setState(Weather::STATE_STORM);

        $manager->flush();
    }
}
