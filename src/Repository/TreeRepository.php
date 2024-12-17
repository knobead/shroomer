<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tree;
use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tree|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tree|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tree[]    findAll()
 * @method Tree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tree::class);
    }

    /**
     * @param Zone $zone
     *
     * @return Tree[]
     */
    public function findWithMyceliumsByZone(Zone $zone): array
    {
        return $this->createQueryBuilder('tree')
            ->select('tree')
            ->addSelect('mycelium')
            ->join('tree.myceliums', 'mycelium')
            ->getQuery()
            ->getResult();
    }
}
