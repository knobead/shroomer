<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\NotExposed;
use App\Repository\MyceliumRepository;
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

#[Entity(repositoryClass: MyceliumRepository::class)]
class Mycelium
{
    public const string GENUS_AMANITA      ='amanita';
    public const string GENUS_BOLETUS      ='boletus';
    public const string GENUS_CANTHARELLUS ='cantharellus';
    public const string GENUS_PLEUROTUS    ='pleurotus';
    public const string GENUS_XEROCOMUS    ='xerocomus';

    public const array GENUSES =[
        self::GENUS_AMANITA,
        self::GENUS_BOLETUS,
        self::GENUS_CANTHARELLUS,
        self::GENUS_PLEUROTUS,
        self::GENUS_XEROCOMUS,
    ];

    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(type: Types::INTEGER, nullable: false)]
    private ?int $id = null;

    #[Column(name: "genus", type: Types::STRING, length: 20, nullable: false)]
    private string $genus;

    #[ManyToOne(targetEntity: Zone::class, inversedBy: "myceliums")]
    #[JoinColumn(nullable: false)]
    private Zone $zone;

    #[OneToMany(targetEntity: Sporocarp::class, mappedBy: 'mycelium')]
    private Collection $sporocarps;

    public function __construct()
    {
        $this->sporocarps = new ArrayCollection();
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
    public function getSporocarps(): Collection
    {
        return $this->sporocarps;
    }

    /**
     * @param Sporocarp $sporocarp
     *
     * @return void
     */
    public function addSporocarp(Sporocarp $sporocarp): void
    {
        foreach ($this->sporocarps as $carp) {
            if ($carp->getId() === $sporocarp->getId()) {
                return;
            }
        }

        $this->sporocarps[] = $sporocarp;
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): void
    {
        $this->genus = $genus;
    }
}
