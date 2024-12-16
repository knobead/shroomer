<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

use App\Condition\MinMaxTemperature;
use App\Entity\MyceliumGenusEnum;

class AmanitaConditionBagBuilder implements ConditionBagBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function supports(MyceliumGenusEnum $genus): bool
    {
        return MyceliumGenusEnum::GENUS_AMANITA === $genus;
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
