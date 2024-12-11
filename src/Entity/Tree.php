<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TreeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
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
    #[Groups(Zone::class)]
    private string $genus;

    #[ManyToOne(targetEntity: Zone::class, inversedBy: "trees")]
    #[JoinColumn(nullable: false)]
    private Zone $zone;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     *
     * @return void
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getGenus(): string
    {
        return $this->genus;
    }

    /**
     * @param string $genus
     *
     * @return void
     */
    public function setGenus(string $genus): void
    {
        $this->genus = $genus;
    }

    /**
     * @return Zone
     */
    public function getZone(): Zone
    {
        return $this->zone;
    }

    /**
     * @param Zone $zone
     *
     * @return void
     */
    public function setZone(Zone $zone): void
    {
        $this->zone = $zone;
    }
}
