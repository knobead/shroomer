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

    public function __construct(ChainWeatherGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function __invoke(GenerateWeatherMessage $generateWeatherMessage): void
    {
        $state = Weather::STATES[rand(0, count(Weather::STATES)-1)];
        $this->generator->generate($state);
    }
}
