<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Generator\Message\GenerateEveryMyceliumsMessage;
use App\Generator\Message\GenerateMyceliumMessage;
use App\Repository\MyceliumRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GenerateEveryMyceliumsHandler
{
    private MyceliumRepository $myceliumRepository;
    private MessageBusInterface $messageBus;

    /**
     * @param MyceliumRepository      $myceliumRepository
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MyceliumRepository $myceliumRepository, MessageBusInterface $messageBus)
    {
        $this->myceliumRepository = $myceliumRepository;
        $this->messageBus = $messageBus;
    }

    /**
     * @param GenerateEveryMyceliumsMessage $generateEveryMyceliumsMessage
     *
     * @return void
     * @throws ExceptionInterface
     */
    public function __invoke(GenerateEveryMyceliumsMessage $generateEveryMyceliumsMessage): void
    {
        $myceliums = $this->myceliumRepository->findAll();

        foreach ($myceliums as $mycelium) {
            $this->messageBus->dispatch(new GenerateMyceliumMessage($mycelium->getId()));
        }
    }
}
