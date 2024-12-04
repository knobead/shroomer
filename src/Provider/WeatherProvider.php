<?php

declare(strict_types=1);

namespace App\Provider;

use ApiPlatform\Exception\NotExposedHttpException;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\WeatherRepository;

class WeatherProvider implements ProviderInterface
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
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     *
     * @return object|array|object[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof GetCollection) {
            throw new NotExposedHttpException();
        }

        return $this->weatherRepository->findLastWeathers(7);
    }
}
