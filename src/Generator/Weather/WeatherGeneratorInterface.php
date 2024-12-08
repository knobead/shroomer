<?php

declare(strict_types=1);

namespace App\Generator\Weather;

use App\Entity\Weather;

interface WeatherGeneratorInterface
{
    /**
     * It should true if the class supports the given weather type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;

    /**
     * It returns the generated weather.
     *
     * @param string $type
     *
     * @return Weather
     */
    public function generate(string $type): Weather;
}
