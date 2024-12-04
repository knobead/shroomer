<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Entity\Weather;
use App\Generator\Message\GenerateWeatherMessage;
use App\Generator\Message\GenerateEveryZonesMessage;
use App\Generator\Message\GenerateZoneMessage;
use App\Generator\Weather\ChainWeatherGenerator;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GenerateEveryZonesHandler
{
    private ZoneRepository $zoneRepository;
    private MessageBusInterface $messageBus;

    /**
     * @param ZoneRepository      $zoneRepository
     * @param MessageBusInterface $messageBus
     */
    public function __construct(ZoneRepository $zoneRepository, MessageBusInterface $messageBus)
    {
        $this->zoneRepository = $zoneRepository;
        $this->messageBus = $messageBus;
    }

    /**
     * @param GenerateEveryZonesMessage $generateEveryZonesMessage
     *
     * @return void
     * @throws ExceptionInterface
     */
    public function __invoke(GenerateEveryZonesMessage $generateEveryZonesMessage): void
    {
        $zones = $this->zoneRepository->findAll();

        foreach ($zones as $zone) {
            $this->messageBus->dispatch(new GenerateZoneMessage($zone->getId()));
        }
    }
}
