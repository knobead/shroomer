<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SporocarpRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity(repositoryClass: SporocarpRepository::class)]
class Sporocarp
{
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

    // wormy sporocarp ... you may eat it if you want
    #[Column(name: 'wormy', type: Types::BOOLEAN, nullable: false)]
    #[Groups(Zone::class)]
    private bool $wormy = false;

    // eaten sporocarp ... some little wildlife must have eat before you find it
    #[Column(name: 'eaten', type: Types::BOOLEAN, nullable: false)]
    #[Groups(Zone::class)]
    private bool $eaten = false;

    // rotten sporocarp, you must NOT eat this !
    #[Column(name: 'rotten', type: Types::BOOLEAN, nullable: false)]
    #[Groups(Zone::class)]
    private bool $rotten = false;

    #[ManyToOne(targetEntity: Zone::class, inversedBy: 'sporocarps')]
    #[JoinColumn(nullable: false)]
    private Zone $zone;

    #[ManyToOne(targetEntity: Mycelium::class, inversedBy: 'sporocarps')]
    #[JoinColumn(nullable: false)]
    private Mycelium $mycelium;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(Zone::class)]
    public function getGenus(): string
    {
        return $this->mycelium->getGenus()->value;
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

    /**
     * @return Mycelium
     */
    public function getMycelium(): Mycelium
    {
        return $this->mycelium;
    }

    /**
     * @param Mycelium $mycelium
     *
     * @return void
     */
    public function setMycelium(Mycelium $mycelium): void
    {
        $this->mycelium = $mycelium;
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

    public function isWormy(): bool
    {
        return $this->wormy;
    }

    public function setWormy(bool $wormy): void
    {
        $this->wormy = $wormy;
    }

    public function isEaten(): bool
    {
        return $this->eaten;
    }

    public function setEaten(bool $eaten): void
    {
        $this->eaten = $eaten;
    }

    public function isRotten(): bool
    {
        return $this->rotten;
    }

    public function setRotten(bool $rotten): void
    {
        $this->rotten = $rotten;
    }
}
