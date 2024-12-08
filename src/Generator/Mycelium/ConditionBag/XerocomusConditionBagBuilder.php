<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Condition\CurrentWeather;
use App\Condition\MinMaxTemperature;
use App\Entity\Mycelium;
use App\Entity\Weather;

class XerocomusConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $type): bool
    {
        return Mycelium::GENUS_XEROCOMUS === $type;
    }

    /**
     * @inheritDoc
     */
    public function builds(): array
    {
        return [
            new MinMaxTemperature(minimumTemperature: 10, maximumTemperature: 30),
            new CurrentWeather(Weather::STATE_SUNNY),
        ];
    }
}
