<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Generator\Message\GenerateTreeMessage;
use App\Generator\Message\GenerateZoneMessage;
use App\Repository\TreeRepository;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class GenerateZoneHandler
{
    private TreeRepository $treeRepository;
    private MessageBusInterface $messageBus;

    /**
     * @param MessageBusInterface    $messageBus
     * @param TreeRepository         $treeRepository
     */
    public function __construct(MessageBusInterface $messageBus, TreeRepository $treeRepository)
    {
        $this->treeRepository = $treeRepository;
        $this->messageBus = $messageBus;
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

        foreach ($trees as $tree) {
            $id = $tree->getId();

            if (null === $id){
                throw new RuntimeException('tree id could not be null');
            }

            $this->messageBus->dispatch(new GenerateTreeMessage($tree->getId()));
        }
    }
}
