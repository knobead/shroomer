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
    public const string STATE_SUNNY = 'sunny';
    public const string STATE_CLOUDY = 'cloudy';
    public const string STATE_RAIN = 'rain';
    public const string STATE_STORM = 'storm';

    public const array STATES = [self::STATE_SUNNY, self::STATE_CLOUDY, self::STATE_RAIN, self::STATE_STORM];

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

    // weather state (sunny, cloudy, rain, storm)
    #[Column(type: Types::STRING, nullable: false)]
    #[Groups(Weather::class)]
    private string $state;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIteration()
    {
        return $this->iteration;
    }

    /**
     * @param mixed $iteration
     */
    public function setIteration($iteration): void
    {
        $this->iteration = $iteration;
    }

    /**
     * @return mixed
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * @param mixed $humidity
     */
    public function setHumidity($humidity): void
    {
        $this->humidity = $humidity;
    }

    /**
     * @return mixed
     */
    public function getMaxTemperature()
    {
        return $this->maxTemperature;
    }

    /**
     * @param mixed $maxTemperature
     */
    public function setMaxTemperature($maxTemperature): void
    {
        $this->maxTemperature = $maxTemperature;
    }

    /**
     * @return mixed
     */
    public function getMinTemperature()
    {
        return $this->minTemperature;
    }

    /**
     * @param mixed $minTemperature
     */
    public function setMinTemperature($minTemperature): void
    {
        $this->minTemperature = $minTemperature;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }
}
