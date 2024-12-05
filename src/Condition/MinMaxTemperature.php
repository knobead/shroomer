<?php
declare(strict_types=1);

namespace App\Condition;

use RuntimeException;

class MinMaxTemperature extends AbstractCondition
{
    private ?int $minimumTemperature;
    private ?int $maximumTemperature;

    /**
     * @param int|null $minimumTemperature
     * @param int|null $maximumTemperature
     */
    public function __construct(?int $minimumTemperature = null, ?int $maximumTemperature = null)
    {
        if (null === $maximumTemperature && null === $minimumTemperature) {
            throw new RuntimeException(sprintf(
                '%s expect at least a minimum or a maximum temperature, none given',
                self::class
            ));
        }

        $this->minimumTemperature = $minimumTemperature;
        $this->maximumTemperature = $maximumTemperature;
    }

    /**
     * @return int|null
     */
    public function getMinimumTemperature(): ?int
    {
        return $this->minimumTemperature;
    }

    /**
     * @return int|null
     */
    public function getMaximumTemperature(): ?int
    {
        return $this->maximumTemperature;
    }
}
