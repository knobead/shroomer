<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Entity\Mycelium;
use App\Entity\Zone;
use App\Generator\Message\GenerateZoneMessage;
use App\Repository\MyceliumRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\DataCollector\ValidatorDataCollector;

#[AsMessageHandler]
class GenerateZoneHandler
{
    private MyceliumRepository $myceliumRepository;
    private ZoneRepository $zoneRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param MyceliumRepository     $myceliumRepository
     * @param ZoneRepository         $zoneRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MyceliumRepository $myceliumRepository,
        ZoneRepository $zoneRepository
    ) {
        $this->entityManager = $entityManager;
        $this->myceliumRepository = $myceliumRepository;
        $this->zoneRepository = $zoneRepository;
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
        // todo this must be adapted according to a tree system

        $myceliums = $this->myceliumRepository->findByZoneId($generateZoneMessage->getZoneId());

        if (count($myceliums) >= 10) {
            return;
        }

        $mycelium = new Mycelium();
        $mycelium->setZone($zone);
        $mycelium->setGenus(Mycelium::GENUSES[array_rand(Mycelium::GENUSES)]);
        $this->entityManager->persist($mycelium);
        $this->entityManager->flush();
    }
}
