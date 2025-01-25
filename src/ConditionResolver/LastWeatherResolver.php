<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\CurrentWeather;
use App\Condition\LastWeather;
use App\Entity\Zone;
use App\Exception\InvalidContextException;
use App\Repository\WeatherRepository;

class LastWeatherResolver implements ConditionResolverInterface
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
        return $abstractCondition instanceof LastWeather;
    }

    /**
     * @param LastWeather $abstractCondition
     * @param array       $context
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition, array $context = []): bool
    {
        $zone = $context['zone'] ?? null;

        if (!$zone instanceof Zone){
            throw new InvalidContextException('zone', Zone::class);
        }

        $weathers = $this->weatherRepository->findLastWeathers($zone, 1, 1);

        if (1 !== count($weathers)) {
            return false;
        }

        $weather = $weathers[0];

        return $abstractCondition->getWeather() === $weather->getState();
    }
}
