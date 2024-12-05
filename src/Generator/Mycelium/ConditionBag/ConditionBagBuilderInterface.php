<?php

declare(strict_types=1);

namespace App\Generator\Mycelium\ConditionBag;

interface ConditionBagBuilderInterface
{
    /**
     * The methods return true when its support a given mycelium genus.
     *
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;

    /**
     * The method builds a condition bag.
     *
     * @return array
     */
    public function builds(): array;
}
