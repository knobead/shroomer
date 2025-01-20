<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Entity\Sporocarp;
use App\Generator\Message\GenerateSporocarpMessage;
use App\Repository\SporocarpRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateSporocarpHandler
{
    private SporocarpRepository $repository;
    private EntityManagerInterface $manager;

    /**
     * @param SporocarpRepository    $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(SporocarpRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
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

        if ($sporocarp->isRotten()) {
            return;
        }

        $age = $sporocarp->getAge();
        $sporocarp->setAge(++$age);

        $grow = rand(0, 2);
        $size = $sporocarp->getSize();
        $sporocarp->setSize($size + $grow);

        if (5 >= $age) {
            return;
        }

        $wormChance = rand(0, 100);
        $eatenChance = rand(0, 100);

        if (5 >= $wormChance) {
            $sporocarp->setWormy(true);
        }

        if (5 >= $eatenChance) {
            $sporocarp->setEaten(true);
        }

        if (10 >= $age) {
            return;
        }

        $rottenChance = rand(0, 100);

        if ($age >= $rottenChance) {
            $sporocarp->setRotten(true);
        }

        $this->manager->flush();
    }
}
