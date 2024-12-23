<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Mycelium;
use App\Entity\MyceliumGenusEnum;
use App\Entity\Sporocarp;
use App\Entity\Tree;
use App\Entity\TreeGenusesEnum;
use App\Entity\Weather;
use App\Entity\WeatherStateEnum;
use App\Entity\Zone;

final class DummiesFactory
{
    /**
     * @return Weather
     */
    public static function newWeather(): Weather
    {
        $weather = new Weather();
        $weather->setHumidity(0);
        $weather->setMinTemperature(10);
        $weather->setMaxTemperature(30);
        $weather->setState(WeatherStateEnum::STATE_SUNNY);

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
     * @param Zone $zone
     *
     * @return Tree
     */
    public static function newTree(Zone $zone): Tree
    {
        $tree = new Tree();
        $tree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $tree->setAge(0);
        $tree->setSize(0);
        $tree->setZone($zone);

        return $tree;
    }

    /**
     *
     * @param Tree $tree
     *
     * @return Mycelium
     */
    public static function newMycelium(Tree $tree): Mycelium
    {
        $mycelium = new Mycelium();
        $mycelium->setTree($tree);
        $mycelium->setZone($tree->getZone());
        $mycelium->setGenus(MyceliumGenusEnum::GENUS_BOLETUS);

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
        $sporocarp->setDikarya(sprintf('%s %s', $mycelium->getGenus()->value, 'edulis'));
        $sporocarp->setAge(1);
        $sporocarp->setSize(5);
        $sporocarp->setRotten(false);
        $sporocarp->setWormy(false);
        $sporocarp->setEaten(false);

        return $sporocarp;
    }
}
