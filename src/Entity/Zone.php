<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(normalizationContext: ['groups' => [Zone::class]])]
class Zone
{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Zone::class)]
    private ?int $id = null;

    #[Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    #[Groups(Zone::class)]
    private string $name;

    // all the sporocarp that can be found in the zone
    #[OneToMany(targetEntity: Sporocarp::class, mappedBy: 'zone')]
    #[Groups(Zone::class)]
    private Collection $sporocarps;

    // all the mycelium that can be found in the zone
    #[OneToMany(targetEntity: Mycelium::class, mappedBy: 'zone')]
    private Collection $myceliums;

    public function __construct()
    {
        $this->sporocarps = new ArrayCollection();
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
            if ($carp->getId() == $sporocarp->getId()) {
                return;
            }
        }

        $this->sporocarps[] = $sporocarp;
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
