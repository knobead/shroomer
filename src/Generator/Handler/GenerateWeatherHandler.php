<?php

namespace App\Generator\Handler;

use App\Entity\WeatherStateEnum;
use App\Entity\Zone;
use App\Generator\Message\GenerateWeatherMessage;
use App\Generator\Weather\ChainWeatherGenerator;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateWeatherHandler
{
    private ChainWeatherGenerator $generator;
    private ZoneRepository $zoneRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param ChainWeatherGenerator  $generator
     * @param ZoneRepository         $zoneRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ChainWeatherGenerator $generator,
        ZoneRepository $zoneRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->generator = $generator;
        $this->zoneRepository = $zoneRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param GenerateWeatherMessage $generateWeatherMessage
     *
     * @return void
     */
    public function __invoke(GenerateWeatherMessage $generateWeatherMessage): void
    {
        $zone = $this->zoneRepository->find($generateWeatherMessage->getZoneId());

        if(!$zone instanceof Zone){
            throw new RuntimeException('Zone not found');
        }

        $weather = $this->generator->generate($this->generateState());
        $weather->setZone($zone);

        $this->entityManager->persist($weather);
        $this->entityManager->flush();
    }

    /**
     * It generates a random weather state.
     *
     * Todo: This could be part of a seasonal behaviour.
     *
     * @return WeatherStateEnum
     */
    private function generateState(): WeatherStateEnum
    {
        $rand = rand(0, 100);

        if ($rand >= 90) {
            return WeatherStateEnum::STATE_STORM;
        }

        if ($rand >= 60) {
            return WeatherStateEnum::STATE_RAIN;
        }

        if ($rand >= 40) {
            return WeatherStateEnum::STATE_CLOUDY;
        }

        return WeatherStateEnum::STATE_SUNNY;
    }
}
