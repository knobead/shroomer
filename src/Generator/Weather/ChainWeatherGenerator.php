<?php

declare(strict_types=1);

namespace App\Generator\Weather;

use App\Entity\WeatherStateEnum;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

class ChainWeatherGenerator
{
    private iterable $generators;
    private EntityManagerInterface $entityManager;

    /**
     * @param iterable               $generators
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(iterable $generators, EntityManagerInterface $entityManager)
    {
        $this->generators = $generators;
        $this->entityManager = $entityManager;
    }

    /**
     * It must generate a weather and persist it in database.
     *
     * @param WeatherStateEnum $type
     *
     * @return void
     */
    public function generate(WeatherStateEnum $type): void
    {
        $weather = $this->getGenerator($type)->generate($type);
        $this->entityManager->persist($weather);
        $this->entityManager->flush();
    }

    /**
     * It returns the correct generator.
     *
     * @param WeatherStateEnum $type
     *
     * @return WeatherGeneratorInterface
     */
    private function getGenerator(WeatherStateEnum $type): WeatherGeneratorInterface
    {
        foreach ($this->generators as $generator) {
            if ($generator->supports($type)) {
                return $generator;
            }
        }

        throw new RuntimeException(sprintf(
            'No %s found to support "%s"',
            WeatherGeneratorInterface::class,
            $type->value
        ));
    }
}
