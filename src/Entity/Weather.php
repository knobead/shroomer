<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Provider\WeatherProvider;
use App\Repository\WeatherRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[Entity(repositoryClass: WeatherRepository::class)]
#[ApiResource(
    operations: [new GetCollection(uriTemplate: 'weathers')],
    normalizationContext: ['groups' => [Weather::class]],
    provider: WeatherProvider::class
)]
class Weather
{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Weather::class)]
    #[SerializedName('iteration')]
    private ?int $id = null;

    // humidity percentage
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Weather::class)]
    private int $humidity;

    // max temperature (celsius)
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Weather::class)]
    private int $maxTemperature;

    // min temperature (celsius)
    #[Column(type: Types::INTEGER, nullable: false)]
    #[Groups(Weather::class)]
    private int $minTemperature;

    #[Column(type: Types::STRING, nullable: false, enumType: WeatherStateEnum::class)]
    #[Groups(Weather::class)]
    private WeatherStateEnum $state;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getHumidity(): int
    {
        return $this->humidity;
    }

    /**
     * @param int $humidity
     *
     * @return void
     */
    public function setHumidity(int $humidity): void
    {
        $this->humidity = $humidity;
    }

    /**
     * @return int
     */
    public function getMaxTemperature(): int
    {
        return $this->maxTemperature;
    }

    /**
     * @param int $maxTemperature
     *
     * @return void
     */
    public function setMaxTemperature(int $maxTemperature): void
    {
        $this->maxTemperature = $maxTemperature;
    }

    /**
     * @return int
     */
    public function getMinTemperature(): int
    {
        return $this->minTemperature;
    }

    /**
     * @param int $minTemperature
     *
     * @return void
     */
    public function setMinTemperature(int $minTemperature): void
    {
        $this->minTemperature = $minTemperature;
    }

    /**
     * @return WeatherStateEnum
     */
    public function getState(): WeatherStateEnum
    {
        return $this->state;
    }

    /**
     * @param WeatherStateEnum $state
     *
     * @return void
     */
    public function setState(WeatherStateEnum $state): void
    {
        $this->state = $state;
    }
}
