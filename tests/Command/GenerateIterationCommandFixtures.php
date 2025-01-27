<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Entity\MyceliumGenusEnum;
use App\Entity\TreeGenusesEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class GenerateIterationCommandFixtures extends Fixture
{
    public const string ZONE_REFERENCE = 'zone_reference';
    public const string OTHER_ZONE_REFERENCE = 'other_zone_reference';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        $zone = DummiesFactory::newZone(self::ZONE_REFERENCE);
        $this->addReference(self::ZONE_REFERENCE, $zone);
        $manager->persist($zone);

        $otherZone = DummiesFactory::newZone(self::OTHER_ZONE_REFERENCE);
        $this->addReference(self::OTHER_ZONE_REFERENCE, $otherZone);
        $manager->persist($otherZone);

        $treeWithPleurotus = DummiesFactory::newTree($zone);
        $treeWithPleurotus->setAge(250);
        $treeWithPleurotus->setGenus(TreeGenusesEnum::GENUS_PINUS);
        $manager->persist($treeWithPleurotus);

        $mycelium = DummiesFactory::newMycelium($treeWithPleurotus);
        $mycelium->setGenus(MyceliumGenusEnum::GENUS_PLEUROTUS);
        $manager->persist($mycelium);

        $treeToPopulate = DummiesFactory::newTree($otherZone);
        $treeToPopulate->setAge(60);
        $manager->persist($treeToPopulate);

        $manager->flush();
    }
}
