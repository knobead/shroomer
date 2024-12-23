<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\MinMaxTemperature;
use App\Repository\WeatherRepository;
use RuntimeException;

class MinMaxTemperatureResolver implements ConditionResolverInterface
{
    private WeatherRepository $weatherRepository;

    /**
     * @param WeatherRepository $weatherRepository
     */
    public function __construct(WeatherRepository $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @inheritDoc
     */
    public function supports(AbstractCondition $abstractCondition): bool
    {
        return MinMaxTemperature::class === $abstractCondition::class;
    }

    /**
     *
     * @param MinMaxTemperature $abstractCondition
     * @param array             $context
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition, array $context): bool
    {
        $weathers = $this->weatherRepository->findLastWeathers(1);

        if (1 !== count($weathers)) {
            throw new RuntimeException('no weather found');
        }

        $weather = $weathers[0];
        $min = $abstractCondition->getMinimumTemperature();
        $max = $abstractCondition->getMaximumTemperature();

        if (null === $max) {
            return $min <= $weather->getMinTemperature();
        }
        if (null === $min) {
            return $max >= $weather->getMaxTemperature();
        }

        return $min <= $weather->getMinTemperature() && $max >= $weather->getMaxTemperature();
    }
}
