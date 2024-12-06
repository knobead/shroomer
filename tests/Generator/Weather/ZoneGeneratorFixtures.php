<?php

declare(strict_types=1);

namespace App\Tests\Generator\Weather;

use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZoneGeneratorFixtures extends Fixture
{
    public const ZONE_REFERENCE = 'zone';
    public const ZONE_MANY_MYCELIUM_REFERENCE = 'zone_mycelium';

    public function load(ObjectManager $manager)
    {
        $zone = DummiesFactory::newZone('a first zone');
        $this->addReference(self::ZONE_REFERENCE, $zone);
        $manager->persist($zone);

        $secondZone = DummiesFactory::newZone('a second zone');
        for ($i = 0; $i < 10; $i++) {
            $mycelium = DummiesFactory::newMycelium($secondZone);
            $manager->persist($mycelium);
        }
        $this->addReference(self::ZONE_MANY_MYCELIUM_REFERENCE, $secondZone);
        $manager->persist($secondZone);

        $manager->flush();
    }
}
