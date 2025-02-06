<?php

declare(strict_types=1);

namespace App\Command;

use App\Generator\Message\GenerateZoneMessage;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
    public const string COUNT_OPTION = 'count';

    private MessageBusInterface $messageBus;
    private ZoneRepository $zoneRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param MessageBusInterface $generationBus
     * @param ZoneRepository      $zoneRepository
     */
    public function __construct(MessageBusInterface $generationBus, ZoneRepository $zoneRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->messageBus = $generationBus;
        $this->zoneRepository = $zoneRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('it generate iteration of the shroomer simulator')
            ->addOption(
                self::COUNT_OPTION,
                'c',
                InputOption::VALUE_REQUIRED,
                'Number of iterations to operate'
            );
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
        $count = $input->getOption(self::COUNT_OPTION);

        if (!is_numeric($count)) {
            $count = 1;
        }

        for ($i = 0; $i < $count; $i++) {
            $output->writeln(sprintf('<info>Iteration number:</info> %d', $i));
            $zones = $this->zoneRepository->findAll();

            foreach ($zones as $zone) {
                $zoneId = $zone->getId();
                $this->messageBus->dispatch(new GenerateZoneMessage($zoneId));
            }

            $this->entityManager->clear();
        }

        return 0;
    }
}
