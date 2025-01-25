<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\AverageHumidity;
use App\Entity\Zone;
use App\Exception\InvalidContextException;
use App\Repository\WeatherRepository;
use RuntimeException;

class AverageHumidityResolver implements ConditionResolverInterface
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
        return $abstractCondition instanceof AverageHumidity;
    }

    /**
     *
     * @param AverageHumidity $abstractCondition
     * @param array             $context *
     *
     * @return bool
     */
    public function resolve(AbstractCondition $abstractCondition, array $context = []): bool
    {
        $zone = $context['zone'] ?? null;

        if (!$zone instanceof Zone){
            throw new InvalidContextException('zone', Zone::class);
        }

        $weathers = $this->weatherRepository->findLastWeathers($zone, $abstractCondition->getDuration());

        if (0 === $count = count($weathers)) {
            throw new RuntimeException('no weather found');
        }

        $humidity = 0;

        foreach ($weathers as $weather) {
            $humidity += $weather->getHumidity();
        }

        $averageHumidity = $humidity / $count;

        return $abstractCondition->getHumidity() <= $averageHumidity;
    }
}
