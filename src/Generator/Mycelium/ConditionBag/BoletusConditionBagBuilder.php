<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Condition\CurrentWeather;
use App\Condition\DeltaTemperature;
use App\Condition\LastWeather;
use App\Entity\MyceliumGenusEnum;
use App\Entity\Weather;

class BoletusConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(MyceliumGenusEnum $genus): bool
    {
        return MyceliumGenusEnum::GENUS_BOLETUS === $genus;
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
