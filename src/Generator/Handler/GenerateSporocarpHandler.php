<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Entity\Sporocarp;
use App\Event\Sporocarp\SporocarpEndOfLifeEvent;
use App\Generator\Message\GenerateSporocarpMessage;
use App\Repository\SporocarpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateSporocarpHandler
{
    private SporocarpRepository $repository;
    private EntityManagerInterface $manager;
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @param SporocarpRepository      $repository
     * @param EntityManagerInterface   $manager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        SporocarpRepository $repository,
        EntityManagerInterface $manager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param GenerateSporocarpMessage $sporocarpMessage
     *
     * @return void
     */
    public function __invoke(GenerateSporocarpMessage $sporocarpMessage): void
    {
        $sporocarp = $this->repository->find($sporocarpMessage->getSporocarpId());

        if (!$sporocarp instanceof Sporocarp) {
            throw new RuntimeException('Sporocarp not found');
        }

        if ($this->handlesEndOfLife($sporocarp)) {
            $this->eventDispatcher->dispatch(new SporocarpEndOfLifeEvent($sporocarp));
            $this->manager->flush();

            return;
        }

        $sporocarp->toNextAge();
        $sporocarp->setSize($sporocarp->getSize() + rand(0, 2));

        if ($this->handlesEatenBehaviour($sporocarp) || $this->handlesWormBehaviour($sporocarp)) {
            $this->manager->flush();

            return;
        }

        $this->handlesRottenBehaviour($sporocarp);
        $this->manager->flush();
    }

    /**
     * The method handles end of life of a sporocarp.
     *
     * It returns true once a endOfLife states is reached and handled.
     *
     * @param Sporocarp $sporocarp
     *
     * @return bool
     */
    private function handlesEndOfLife(Sporocarp $sporocarp): bool
    {
        if (!$sporocarp->isEaten() && !$sporocarp->isWormy() && !$sporocarp->isRotten()) {
            return false;
        }

        if ($sporocarp->isRotten()) {
            $this->manager->remove($sporocarp);
            $this->manager->flush();
        } else {
            $sporocarp->setRotten(true);
        }

        return true;
    }

    /**
     * @param Sporocarp $sporocarp
     *
     * @return bool
     */
    private function handlesWormBehaviour(Sporocarp $sporocarp): bool
    {
        if ($sporocarp->isYoungerThan(5)) {
            return false;
        }

        $chance = rand(0, 100);

        if (5 <= $chance) {
            return false;
        }

        $sporocarp->setWormy(true);

        return true;
    }

    /**
     * @param Sporocarp $sporocarp
     *
     * @return bool
     */
    private function handlesEatenBehaviour(Sporocarp $sporocarp): bool
    {
        if ($sporocarp->isYoungerThan(5)) {
            return false;
        }

        $chance = rand(0, 100);

        if (5 <= $chance) {
            return false;
        }

        $sporocarp->setEaten(true);

        return true;
    }

    /**
     * @param Sporocarp $sporocarp
     *
     * @return bool
     */
    private function handlesRottenBehaviour(Sporocarp $sporocarp): bool
    {
        if ($sporocarp->isYoungerThan(10)) {
            return false;
        }

        $chance = rand(0, 40);

        if ($sporocarp->isYoungerThan($chance)) {
            return false;
        }

        $sporocarp->setRotten(true);

        return true;
    }
}
