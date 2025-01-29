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
#[ApiResource(operations: [new Post(uriTemplate: 'tree', security: "is_granted('tree_add', user)")])]
class Tree implements DatableInterface
{
    use DatableTrait;

    public const array MYCELIUM_SLOT_PER_AGES = [
        0 => 0,
        50 => 1,
        150 => 2,
        400 => 3
    ];

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
     * It returns the number of mycelium slot according to the age
     *
     * @param int $age
     *
     * @return int
     */
    public static function getMyceliumSlot(int $age): int
    {
        $keys = array_reverse(array_keys(self::MYCELIUM_SLOT_PER_AGES));

        foreach ($keys as $key) {
            if ($key <= $age) {
                return self::MYCELIUM_SLOT_PER_AGES[$key];
            }
        }

        return 0;
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
