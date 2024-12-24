<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\DeltaTemperature;
use App\Repository\WeatherRepository;
use RuntimeException;

class DeltaTemperatureResolver implements ConditionResolverInterface
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
        return $abstractCondition instanceof DeltaTemperature;
    }

    /**
     * @param DeltaTemperature  $abstractCondition
     * @param array             $context
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition, array $context = []): bool
    {
        $weathers = $this->weatherRepository->findLastWeathers(1);

        if (1 !== count($weathers)) {
            throw new RuntimeException('no weather found');
        }

        $weather = $weathers[0];
        $currentDelta = $weather->getMaxTemperature() - $weather->getMinTemperature();

        return $abstractCondition->getMinimumDelta() <= $currentDelta;
    }
}
