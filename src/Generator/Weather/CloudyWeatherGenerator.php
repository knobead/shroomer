<?php

declare(strict_types=1);

namespace App\Generator\Weather;

use App\Entity\Weather;

class CloudyWeatherGenerator implements WeatherGeneratorInterface
{
    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool
    {
        return Weather::STATE_CLOUDY === $type;
    }

    /**
     * @param string $type
     *
     * @return Weather
     */
    public function generate(string $type): Weather
    {
        $weather = new Weather();
        $weather->setState(Weather::STATE_CLOUDY);
        $weather->setHumidity(50);
        $weather->setMaxTemperature(rand(10,15));
        $weather->setMinTemperature(rand(5,10));

        return $weather;
    }
}
