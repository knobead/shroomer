<?php

namespace App\Generator\Handler;

use App\Entity\Weather;
use App\Generator\Message\GenerateWeatherMessage;
use App\Generator\Weather\ChainWeatherGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GenerateWeatherHandler
{
    private ChainWeatherGenerator $generator;

    /**
     * @param ChainWeatherGenerator $generator
     */
    public function __construct(ChainWeatherGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param GenerateWeatherMessage $generateWeatherMessage
     *
     * @return void
     */
    public function __invoke(GenerateWeatherMessage $generateWeatherMessage): void
    {
        $this->generator->generate($this->generateState());
    }

    /**
     * It generates a random weather state.
     *
     * Todo: This could be part of a seasonal behaviour.
     *
     * @return string
     */
    private function generateState(): string
    {
        $rand = rand(0, 100);

        if ($rand >= 90) {
            return Weather::STATE_STORM;
        }

        if ($rand >= 60) {
            return Weather::STATE_RAIN;
        }

        if ($rand >= 40) {
            return Weather::STATE_CLOUDY;
        }

        return Weather::STATE_SUNNY;
    }
}
