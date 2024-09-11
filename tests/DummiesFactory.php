<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Zone;

final class DummiesFactory
{
    public static function newZone(?string $name): Zone
    {
        $garden = new Zone();
        $garden->setName($name ?? 'garden');

        return $garden;
    }
}
