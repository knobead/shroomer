<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Condition\MinMaxTemperature;
use App\Entity\Mycelium;

class PleurotusConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $type): bool
    {
        return Mycelium::GENUS_PLEUROTUS === $type;
    }

    /**
     * @inheritDoc
     */
    public function builds(): array
    {
        return [
            new MinMaxTemperature(minimumTemperature: 0, maximumTemperature: 15),
        ];
    }
}
