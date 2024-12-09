<?php

declare(strict_types=1);

namespace App\Generator\Weather;

use App\Entity\Weather;

class StormWeatherGenerator implements WeatherGeneratorInterface
{
    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return Weather::STATE_STORM === $type;
    }

    /**
     * @param string $type
     *
     * @return Weather
     */
    public function generate(string $type): Weather
    {
        $weather = new Weather();
        $weather->setState(Weather::STATE_STORM);
        $weather->setHumidity(100);
        $weather->setMaxTemperature(rand(5,15));
        $weather->setMinTemperature(rand(0,10));

        return $weather;
    }
}
