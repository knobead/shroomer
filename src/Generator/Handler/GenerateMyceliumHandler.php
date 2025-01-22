<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\ConditionResolver\ConditionResolver;
use App\Entity\Mycelium;
use App\Entity\Sporocarp;
use App\Generator\Message\GenerateMyceliumMessage;
use App\Generator\Mycelium\ConditionBag\ConditionBagBuilder;
use App\Repository\MyceliumRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateMyceliumHandler
{
    private MyceliumRepository $myceliumRepository;
    private ConditionBagBuilder $conditionBagBuilder;
    private ConditionResolver $conditionResolver;
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param MyceliumRepository     $myceliumRepository
     * @param ConditionBagBuilder    $conditionBagBuilder
     * @param ConditionResolver      $conditionResolver
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MyceliumRepository $myceliumRepository,
        ConditionBagBuilder $conditionBagBuilder,
        ConditionResolver $conditionResolver
    )
    {
        $this->myceliumRepository = $myceliumRepository;
        $this->conditionBagBuilder = $conditionBagBuilder;
        $this->conditionResolver = $conditionResolver;
        $this->entityManager = $entityManager;
    }

    /**
     * @param GenerateMyceliumMessage $generateMyceliumMessage
     *
     * @return void
     */
    public function __invoke(GenerateMyceliumMessage $generateMyceliumMessage)
    {
        $id = $generateMyceliumMessage->getMyceliumId();
        $mycelium = $this->myceliumRepository->find($id);

        if (!$mycelium instanceof Mycelium) {
            throw new RuntimeException(sprintf(
                'the %s with id %d was not found',
                Mycelium::class,
                $id
            ));
        }

        $conditions = $this->conditionBagBuilder->build($mycelium->getGenus());

        foreach ($conditions as $condition) {
            if (!$this->conditionResolver->resolve($condition)) {
                return;
            }
        }

        $sporocarp = new Sporocarp();
        $sporocarp->setMycelium($mycelium);
        $sporocarp->setZone($mycelium->getTree()->getZone());
        $sporocarp->setWormy(false);
        $sporocarp->setEaten(false);
        $sporocarp->setRotten(false);
        $sporocarp->setSize(1);
        $sporocarp->setAge(1);

        $this->entityManager->persist($sporocarp);

        $this->entityManager->flush();
    }
}
