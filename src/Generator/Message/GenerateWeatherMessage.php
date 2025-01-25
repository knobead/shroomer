<?php

declare(strict_types=1);

namespace App\Generator\Message;

class GenerateWeatherMessage
{
    private int $zoneId;

    /**
     * @param int $zoneId
     */
    public function __construct(int $zoneId)
    {
        $this->zoneId = $zoneId;
    }

    /**
     * @return int
     */
    public function getZoneId(): int
    {
        return $this->zoneId;
    }
}
