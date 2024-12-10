<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity(repositoryClass: TreeRepository::class)]
class Tree
{
    public const string GENUS_FRAXINUS      ='fraxinus';
    public const string GENUS_CASTANEA      ='castanera';
    public const string GENUS_QUERCUS      ='quercus';
    public const string GENUS_PINUS      ='pinus';

    public const array GENUSES =[
        self::GENUS_FRAXINUS,
        self::GENUS_CASTANEA,
        self::GENUS_QUERCUS,
        self::GENUS_PINUS,
    ];

    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    private ?int $id = null;

    // size in cm
    #[Column(name: 'size', type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    private int $size = 0;

    // age in day / iteration
    #[Column(name: 'age', type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    private int $age = 0;

    #[Column(name: "genus", type: Types::STRING, length: 20, nullable: false)]
    private string $genus;
}
