<?php

declare(strict_types=1);

namespace App\Command;

use App\Generator\Message\GenerateEveryMyceliumsMessage;
use App\Generator\Message\GenerateEveryZonesMessage;
use App\Generator\Message\GenerateWeatherMessage;
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

    /**
     * @param MessageBusInterface $generationBus
     */
    public function __construct(MessageBusInterface $generationBus)
    {
        parent::__construct();
        $this->messageBus = $generationBus;
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
        $this->messageBus->dispatch(new GenerateWeatherMessage());
        $this->messageBus->dispatch(new GenerateEveryZonesMessage());
        $this->messageBus->dispatch(new GenerateEveryMyceliumsMessage());

        return 0;
    }
}
