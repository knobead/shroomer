<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Condition\AverageHumidity;
use App\Condition\MinMaxTemperature;
use App\Entity\Mycelium;

class CantharellusConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $type): bool
    {
        return Mycelium::GENUS_CANTHARELLUS === $type;
    }

    /**
     * @inheritDoc
     */
    public function builds(): array
    {
        return [
            new AverageHumidity(humidity: 50, duration: 4),
        ];
    }
}
