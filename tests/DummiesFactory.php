<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Mycelium;
use App\Entity\Sporocarp;
use App\Entity\Weather;
use App\Entity\Zone;

final class DummiesFactory
{
    /**
     * @param int $iteration
     *
     * @return Weather
     */
    public static function newWeather(int $iteration): Weather
    {
        $weather = new Weather();
        $weather->setIteration($iteration);
        $weather->setHumidity(0);
        $weather->setMinTemperature(10);
        $weather->setMaxTemperature(30);
        $weather->setState(Weather::STATE_SUNNY);

        return $weather;
    }

    /**
     * @param string|null $name
     *
     * @return Zone
     */
    public static function newZone(?string $name): Zone
    {
        $zone = new Zone();
        $zone->setName($name ?? 'zone');

        return $zone;
    }

    /**
     * @param Zone        $zone
     *
     * @return Mycelium
     */
    public static function newMycelium(Zone $zone): Mycelium
    {
        $mycelium = new Mycelium();
        $mycelium->setZone($zone);
        $mycelium->setGenus(Mycelium::GENUS_BOLETUS);

        return $mycelium;
    }

    /**
     * @param Mycelium    $mycelium
     * @param string|null $name
     *
     * @return Sporocarp
     */
    public static function newSporocarp(Mycelium $mycelium, ?string $name): Sporocarp
    {
        $sporocarp = new Sporocarp();
        $sporocarp->setMycelium($mycelium);
        $sporocarp->setDikarya(sprintf('%s %s', $mycelium->getGenus(), 'edulis'));
        $sporocarp->setName($name ?? 'sporocarp');
        $sporocarp->setAge(1);
        $sporocarp->setSize(5);
        $sporocarp->setRotten(false);
        $sporocarp->setWormy(false);
        $sporocarp->setEaten(false);

        return $sporocarp;
    }
}
