<?php

declare(strict_types=1);

namespace App\Condition;

class LastWeather extends AbstractCondition
{
    private string $weather;

    /**
     * @param string $weather
     */
    public function __construct(string $weather)
    {
        $this->weather = $weather;
    }

    public function getWeather(): string
    {
        return $this->weather;
    }
}
