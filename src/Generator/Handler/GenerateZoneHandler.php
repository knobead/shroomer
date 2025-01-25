<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Generator\Message\GenerateMyceliumMessage;
use App\Generator\Message\GenerateSporocarpMessage;
use App\Generator\Message\GenerateTreeMessage;
use App\Generator\Message\GenerateWeatherMessage;
use App\Generator\Message\GenerateZoneMessage;
use App\Repository\MyceliumRepository;
use App\Repository\SporocarpRepository;
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
    private SporocarpRepository $sporocarpRepository;

    /**
     * @param MessageBusInterface $messageBus
     * @param TreeRepository      $treeRepository
     * @param MyceliumRepository  $myceliumRepository
     * @param SporocarpRepository $sporocarpRepository
     */
    public function __construct(
        MessageBusInterface $messageBus,
        TreeRepository $treeRepository,
        MyceliumRepository $myceliumRepository,
        SporocarpRepository $sporocarpRepository
    ) {
        $this->treeRepository = $treeRepository;
        $this->messageBus = $messageBus;
        $this->myceliumRepository = $myceliumRepository;
        $this->sporocarpRepository = $sporocarpRepository;
    }

    /**
     * @param GenerateZoneMessage $generateZoneMessage
     *
     * @return void
     * @throws ExceptionInterface
     */
    public function __invoke(GenerateZoneMessage $generateZoneMessage): void
    {
        $this->messageBus->dispatch(new GenerateWeatherMessage($generateZoneMessage->getZoneId()));

        $trees = $this->treeRepository->findByZone($generateZoneMessage->getZoneId());
        $myceliums = $this->myceliumRepository->findByZoneId($generateZoneMessage->getZoneId());
        $sporocarps = $this->sporocarpRepository->findByZone($generateZoneMessage->getZoneId());

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

        foreach ($sporocarps as $sporocarp) {
            /** @var int $id */
            $id = $sporocarp->getId();
            $this->messageBus->dispatch(new GenerateSporocarpMessage($id));
        }
    }
}
