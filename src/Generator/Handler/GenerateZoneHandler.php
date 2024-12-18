<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Entity\Mycelium;
use App\Entity\MyceliumGenusEnum;
use App\Entity\Zone;
use App\Generator\Message\GenerateZoneMessage;
use App\Repository\MyceliumRepository;
use App\Repository\TreeRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateZoneHandler
{
    private MyceliumRepository $myceliumRepository;
    private ZoneRepository $zoneRepository;
    private EntityManagerInterface $entityManager;
    private TreeRepository $treeRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param MyceliumRepository     $myceliumRepository
     * @param ZoneRepository         $zoneRepository
     * @param TreeRepository         $treeRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MyceliumRepository $myceliumRepository,
        ZoneRepository $zoneRepository,
        TreeRepository $treeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->myceliumRepository = $myceliumRepository;
        $this->zoneRepository = $zoneRepository;
        $this->treeRepository = $treeRepository;
    }

    /**
     * @param GenerateZoneMessage $generateZoneMessage
     *
     * @return void
     */
    public function __invoke(GenerateZoneMessage $generateZoneMessage): void
    {
        /** @var Zone $zone */
        $zone = $this->zoneRepository->find($generateZoneMessage->getZoneId());
        $trees = $this->treeRepository->findWithMyceliumsByZone($generateZoneMessage->getZoneId());


        $myceliums = $this->myceliumRepository->findByZoneId($generateZoneMessage->getZoneId());

        if (count($myceliums) >= 10) {
            return;
        }

        $mycelium = new Mycelium();
        $genuses = MyceliumGenusEnum::cases();
        $mycelium->setZone($zone);
        $mycelium->setGenus($genuses[array_rand($genuses)]);
        $this->entityManager->persist($mycelium);
        $this->entityManager->flush();
    }
}
