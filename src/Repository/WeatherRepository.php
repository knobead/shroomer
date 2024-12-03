<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Weather|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weather|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weather[]    findAll()
 * @method Weather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weather::class);
    }

    /**
     * @return Weather[]
     */
    public function findLastSevenWeathers(): array
    {
        return $this->createQueryBuilder('weather')
            ->orderBy('weather.iteration', 'desc')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult();
    }
}