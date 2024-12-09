<?php

declare(strict_types=1);

namespace App\Generator\Weather;

use App\Entity\Weather;

class SunnyWeatherGenerator implements WeatherGeneratorInterface
{
    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return Weather::STATE_SUNNY === $type;
    }

    /**
     * @param string $type
     *
     * @return Weather
     */
    public function generate(string $type): Weather
    {
        $weather = new Weather();
        $weather->setState(Weather::STATE_SUNNY);
        $weather->setHumidity(0);
        $weather->setMaxTemperature(rand(15,25));
        $weather->setMinTemperature(rand(0,10));

        return $weather;
    }
}
