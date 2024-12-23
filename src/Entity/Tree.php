<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\TreeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\EqualTo;

#[Entity(repositoryClass: TreeRepository::class)]
#[ApiResource(operations: [new Post(uriTemplate: 'tree')])]
class Tree implements DatableInterface
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

    #[OneToMany(targetEntity: Mycelium::class, mappedBy: "tree")]
    private Collection $myceliums;

    public function __construct()
    {
        $this->myceliums = new ArrayCollection();
    }

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

    /**
     * @return Collection
     */
    public function getMyceliums(): Collection
    {
        return $this->myceliums;
    }

    /**
     * @param Mycelium $mycelium
     *
     * @return void
     */
    public function addMycelium(Mycelium $mycelium): void
    {
        foreach ($this->myceliums as $mycel) {
            if ($mycel->getId() == $mycelium->getId()) {
                return;
            }
        }

        $this->myceliums[] = $mycelium;
    }
}
