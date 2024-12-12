<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\TreeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\EqualTo;

#[Entity(repositoryClass: TreeRepository::class)]
#[ApiResource(operations: [new Post(uriTemplate: 'tree')])]
class Tree
{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    private ?int $id = null;

    // size in cm
    #[Column(name: 'size', type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    #[EqualTo(value: 0)]
    private int $size = 0;

    // age in day / iteration
    #[Column(name: 'age', type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    #[EqualTo(value: 0)]
    private int $age = 0;

    #[Column(name: "genus", type: Types::STRING, nullable: false, enumType: TreeGenusesEnum::class)]
    #[Groups(Zone::class)]
    private TreeGenusesEnum $genus;

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
     * @return TreeGenusesEnum
     */
    public function getGenus(): TreeGenusesEnum
    {
        return $this->genus;
    }

    /**
     * @param TreeGenusesEnum $genus
     *
     * @return void
     */
    public function setGenus(TreeGenusesEnum $genus): void
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
