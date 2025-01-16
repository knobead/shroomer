<?php

declare(strict_types=1);

namespace App\Generator\Handler;

use App\Entity\Mycelium;
use App\Entity\MyceliumGenusEnum;
use App\Entity\Tree;
use App\Entity\TreeGenusesEnum;
use App\Generator\Message\GenerateTreeMessage;
use App\Repository\TreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateTreeHandler
{
    private TreeRepository $treeRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param TreeRepository $treeRepository
     */
    public function __construct(TreeRepository $treeRepository, EntityManagerInterface $entityManager)
    {
        $this->treeRepository = $treeRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param GenerateTreeMessage $generateTreeMessage
     *
     * @return void
     */
    public function __invoke(GenerateTreeMessage $generateTreeMessage)
    {
        $tree = $this->treeRepository->find($generateTreeMessage->getTreeId());

        if (!$tree instanceof Tree) {
            throw new RuntimeException('Tree not found');
        }

        $age = $tree->getAge();
        $tree->setAge(++$age);
        $this->entityManager->flush();

        $availableMyceliums = TreeGenusesEnum::getMyceliums($tree->getGenus());
        $myceliums = $tree->getMyceliums();
        $myceliumsSlot = floor($age / Tree::ITERATION_FOR_ONE_MYCELIUM);
        $myceliumsCount = count($myceliums);

        if (0 === count($availableMyceliums)) {
            return;
        }

        if (0 >= $myceliumsSlot - $myceliumsCount) {
            return;
        }

        $mycelium = new Mycelium();
        $mycelium->setTree($tree);
        $mycelium->setZone($tree->getZone());
        $mycelium->setGenus($availableMyceliums[array_rand($availableMyceliums)]);

        $this->entityManager->persist($mycelium);
        $this->entityManager->flush();
    }
}
