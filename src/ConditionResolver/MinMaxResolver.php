<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\MinMaxTemperature;
use App\Entity\Weather;
use App\Repository\WeatherRepository;
use RuntimeException;

class MinMaxResolver implements ConditionResolverInterface
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
     * @param MinMaxTemperature $abstractCondition
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition): bool
    {
        $currentWeather = $this->weatherRepository->findLastWeathers(1);

        if (1 !== count($currentWeather)) {
            throw new RuntimeException('no weather found');
        }

        /** @var Weather $currentWeather */
        $currentWeather = $currentWeather[0];

        $min = $abstractCondition->getMinimumTemperature();
        $max = $abstractCondition->getMaximumTemperature();

        if (null === $max) {
            return $min <= $currentWeather->getMinTemperature();
        }
        if (null === $min) {
            return $max >= $currentWeather->getMaxTemperature();
        }

        return $min <= $currentWeather->getMinTemperature() && $max >= $currentWeather->getMaxTemperature();
    }
}
