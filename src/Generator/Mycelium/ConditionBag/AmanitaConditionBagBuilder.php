<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Entity\Mycelium;
use App\Generator\Mycelium\Condition\MinMaxTemperature;

class AmanitaConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $type): bool
    {
        return Mycelium::GENUS_AMANITA === $type;
    }

    /**
     * @inheritDoc
     */
    public function builds(): array
    {
        return [
            new MinMaxTemperature(minimumTemperature: 10, maximumTemperature: 25),
        ];
    }
}
