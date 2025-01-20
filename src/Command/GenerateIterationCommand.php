<?php

declare(strict_types=1);

namespace App\Command;

use App\Generator\Message\GenerateWeatherMessage;
use App\Generator\Message\GenerateZoneMessage;
use App\Repository\ZoneRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:generate:iteration',
    description: 'It generates an iteration of the shroomer simulator',
    hidden: false
)]
class GenerateIterationCommand extends Command
{
    private MessageBusInterface $messageBus;
    private ZoneRepository $zoneRepository;

    /**
     * @param MessageBusInterface $generationBus
     * @param ZoneRepository      $zoneRepository
     */
    public function __construct(MessageBusInterface $generationBus, ZoneRepository $zoneRepository)
    {
        parent::__construct();
        $this->messageBus = $generationBus;
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $zones = $this->zoneRepository->findAll();
        $this->messageBus->dispatch(new GenerateWeatherMessage());

        foreach ($zones as $zone) {
            /** @var int $zoneId */
            $zoneId = $zone->getId();
            $this->messageBus->dispatch(new GenerateZoneMessage($zoneId));
        }

        return 0;
    }
}
