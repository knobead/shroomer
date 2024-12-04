<?php

namespace App\Generator\Handler;

use App\Entity\Weather;
use App\Generator\Message\GenerateWeatherMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GenerateWeatherHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MessageBusInterface $messageBus)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GenerateWeatherMessage $generateWeatherMessage): void
    {
        $state = Weather::STATES[rand(0, count(Weather::STATES)-1)];
    }
}
