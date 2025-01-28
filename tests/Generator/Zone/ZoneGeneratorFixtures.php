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
    public const OTHER_MYCELIUM_REFERENCE = 'mycelium';

    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser();
        $manager->persist($user);

        $zone = DummiesFactory::newZone($user, 'a first zone');
        $this->addReference(self::ZONE_REFERENCE, $zone);
        $manager->persist($zone);

        $tree = DummiesFactory::newTree($zone);
        $tree->setGenus(TreeGenusesEnum::GENUS_PINUS);
        $tree->setAge(500);
        $manager->persist($tree);

        $secondZone = DummiesFactory::newZone($user, 'a second zone');
        $this->addReference(self::ZONE_MANY_MYCELIUM_REFERENCE, $secondZone);
        $manager->persist($secondZone);

        $secondTree = DummiesFactory::newTree($secondZone);
        $secondTree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $secondTree->setAge(40);
        $manager->persist($secondTree);

        $mycelium = DummiesFactory::newMycelium($secondTree);
        $mycelium->setGenus(MyceliumGenusEnum::GENUS_MORCHELLA);
        $manager->persist($mycelium);

        $otherZone = DummiesFactory::newZone($user, 'an other zone');
        $this->addReference(self::OTHER_ZONE_REFERENCE, $otherZone);
        $manager->persist($otherZone);

        $otherTree = DummiesFactory::newTree($otherZone);
        $otherTree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $otherTree->setAge(100);
        $manager->persist($otherTree);

        $otherMycelium = DummiesFactory::newMycelium($otherTree);
        $otherMycelium->setGenus(MyceliumGenusEnum::GENUS_MORCHELLA);
        $this->addReference(self::OTHER_MYCELIUM_REFERENCE, $otherMycelium);
        $manager->persist($otherMycelium);

        $sporocarp = DummiesFactory::newSporocarp($otherMycelium);
        $sporocarp->setZone($otherZone);
        $sporocarp->setAge(0);
        $manager->persist($sporocarp);

        $manager->flush();
    }
}
