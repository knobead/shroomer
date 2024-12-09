<?php

declare(strict_types=1);

namespace App\Generator\Weather;

use App\Entity\Weather;

class RainWeatherGenerator implements WeatherGeneratorInterface
{
    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return Weather::STATE_RAIN === $type;
    }

    /**
     * @param string $type
     *
     * @return Weather
     */
    public function generate(string $type): Weather
    {
        $weather = new Weather();
        $weather->setState(Weather::STATE_RAIN);
        $weather->setHumidity(100);
        $weather->setMaxTemperature(rand(5,15));
        $weather->setMinTemperature(rand(5,10));

        return $weather;
    }
}
