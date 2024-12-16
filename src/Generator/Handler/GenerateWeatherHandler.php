<?php

namespace App\Generator\Handler;

use App\Entity\WeatherStateEnum;
use App\Generator\Message\GenerateWeatherMessage;
use App\Generator\Weather\ChainWeatherGenerator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

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
