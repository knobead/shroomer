<?php

declare(strict_types=1);

namespace App\ConditionResolver;

use App\Condition\AbstractCondition;
use App\Condition\DeltaTemperature;
use App\Entity\Zone;
use App\Exception\InvalidContextException;
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
     * @param DeltaTemperature $abstractCondition
     * @param array            $context
     *
     * @return bool
     * @throws InvalidContextException
     */
    public function resolve(AbstractCondition $abstractCondition, array $context = []): bool
    {
        $zone = $context['zone'] ?? null;

        if (!$zone instanceof Zone){
            throw new InvalidContextException('zone', Zone::class);
        }

        $weathers = $this->weatherRepository->findLastWeathers($zone, 1);

        if (1 !== count($weathers)) {
            throw new RuntimeException('no weather found');
        }

        $weather = $weathers[0];
        $currentDelta = $weather->getMaxTemperature() - $weather->getMinTemperature();

        return $abstractCondition->getMinimumDelta() <= $currentDelta;
    }
}
