<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\CurrentWeather;
use App\Repository\WeatherRepository;
use RuntimeException;

class CurrentWeatherResolver implements ConditionResolverInterface
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
     * @param AbstractCondition $abstractCondition
     *
     * @return bool
     */
    public function supports(AbstractCondition $abstractCondition): bool
    {
        return $abstractCondition instanceof CurrentWeather;
    }

    /**
     * @param CurrentWeather $abstractCondition
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition): bool
    {
        $weathers = $this->weatherRepository->findLastWeathers(1);

        if (1 !== count($weathers)) {
            throw new RuntimeException('no weather found');
        }

        $weather = $weathers[0];

        return $abstractCondition->getWeather() === $weather->getState();
    }
}
