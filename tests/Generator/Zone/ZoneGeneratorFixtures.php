<?php

declare(strict_types=1);

namespace App\Tests\Generator\Zone;

use App\Entity\MyceliumGenusEnum;
use App\Entity\TreeGenusesEnum;
use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZoneGeneratorFixtures extends Fixture
{
    public const ZONE_REFERENCE = 'zone';
    public const ZONE_MANY_MYCELIUM_REFERENCE = 'zone_mycelium';
    public const OTHER_ZONE_REFERENCE = 'other_zone';

    public function load(ObjectManager $manager)
    {
        $weather = DummiesFactory::newWeather();
        $manager->persist($weather);

        $zone = DummiesFactory::newZone('a first zone');
        $this->addReference(self::ZONE_REFERENCE, $zone);
        $manager->persist($zone);

        // age > 150, 3 mycelium spot genus, it must add a 3 myceliums if exectued 2 times
        $tree = DummiesFactory::newTree($zone);
        $tree->setGenus(TreeGenusesEnum::GENUS_PINUS);
        $tree->setAge(160);
        $manager->persist($tree);

        $secondZone = DummiesFactory::newZone('a second zone');
        $this->addReference(self::ZONE_MANY_MYCELIUM_REFERENCE, $secondZone);
        $manager->persist($secondZone);

        $secondTree = DummiesFactory::newTree($secondZone);
        $secondTree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $secondTree->setAge(40);
        $manager->persist($secondTree);
        $mycelium = DummiesFactory::newMycelium($secondTree);
        $mycelium->setGenus(MyceliumGenusEnum::GENUS_MORCHELLA);
        $manager->persist($mycelium);

        $otherZone = DummiesFactory::newZone('an other zone');
        $this->addReference(self::OTHER_ZONE_REFERENCE, $otherZone);
        $manager->persist($otherZone);

        $manager->flush();
    }
}
