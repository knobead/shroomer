<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Generator\Message\GenerateMyceliumMessage;
use App\Generator\Message\GenerateTreeMessage;
use App\Generator\Message\GenerateZoneMessage;
use App\Repository\MyceliumRepository;
use App\Repository\TreeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GenerateZoneHandler
{
    private TreeRepository $treeRepository;
    private MessageBusInterface $messageBus;
    private MyceliumRepository $myceliumRepository;

    /**
     * @param MessageBusInterface $messageBus
     * @param TreeRepository      $treeRepository
     * @param MyceliumRepository  $myceliumRepository
     */
    public function __construct(
        MessageBusInterface $messageBus,
        TreeRepository $treeRepository,
        MyceliumRepository $myceliumRepository
    ) {
        $this->treeRepository = $treeRepository;
        $this->messageBus = $messageBus;
        $this->myceliumRepository = $myceliumRepository;
    }

    /**
     * @param GenerateZoneMessage $generateZoneMessage
     *
     * @return void
     * @throws ExceptionInterface
     */
    public function __invoke(GenerateZoneMessage $generateZoneMessage): void
    {
        $trees = $this->treeRepository->findByZone($generateZoneMessage->getZoneId());
        $myceliums = $this->myceliumRepository->findByZoneId($generateZoneMessage->getZoneId());

        foreach ($trees as $tree) {
            /** @var int $id */
            $id = $tree->getId();
            $this->messageBus->dispatch(new GenerateTreeMessage($id));
        }

        foreach ($myceliums as $mycelium) {
            /** @var int $id */
            $id = $mycelium->getId();
            $this->messageBus->dispatch(new GenerateMyceliumMessage($id));
        }
    }
}
