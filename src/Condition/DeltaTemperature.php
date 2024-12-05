<?php
declare(strict_types=1);

namespace App\Condition;

class DeltaTemperature extends AbstractCondition
{
    private int $delta;

    /**
     * @param int $delta
     */
    public function __construct(int $delta)
    {
        $this->delta = $delta;
    }

    /**
     * @return int
     */
    public function getDelta(): int
    {
        return $this->delta;
    }
}
