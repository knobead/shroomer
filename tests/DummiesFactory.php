<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Sporocarp;
use App\Entity\Zone;

final class DummiesFactory
{
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
     * @param string|null $name
     *
     * @return Sporocarp
     */
    public static function newSporocarp(?string $name): Sporocarp
    {
        $sporocarp = new Sporocarp();
        $sporocarp->setName($name ?? 'sporocarp');
        $sporocarp->setAge(1);
        $sporocarp->setSize(5);
        $sporocarp->setRotten(false);
        $sporocarp->setWormy(false);
        $sporocarp->setEaten(false);

        return $sporocarp;
    }
}
