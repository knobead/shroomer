<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Condition\CurrentWeather;
use App\Condition\DeltaTemperature;
use App\Condition\LastWeather;
use App\Condition\MinMaxTemperature;
use App\Entity\Mycelium;
use App\Entity\Weather;

class BoletusConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $type): bool
    {
        return Mycelium::GENUS_BOLETUS === $type;
    }

    /**
     * @inheritDoc
     */
    public function builds(): array
    {
        return [
            new LastWeather(Weather::STATE_RAIN),
            new CurrentWeather(Weather::STATE_SUNNY),
            new DeltaTemperature(10),
        ];
    }
}
