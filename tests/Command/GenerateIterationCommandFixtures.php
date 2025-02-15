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
    public const string USER_REFERENCE = 'user';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser();
        $this->addReference(self::USER_REFERENCE, $user);

        $zone = DummiesFactory::newZone($user, self::ZONE_REFERENCE);
        $user->addZone($zone);
        $this->addReference(self::ZONE_REFERENCE, $zone);
        $manager->persist($zone);

        $otherZone = DummiesFactory::newZone($user, self::OTHER_ZONE_REFERENCE);
        $user->addZone($otherZone);
        $this->addReference(self::OTHER_ZONE_REFERENCE, $otherZone);
        $manager->persist($otherZone);

        $manager->persist($user);

        $treeWithPleurotus = DummiesFactory::newTree($zone);
        $treeWithPleurotus->setAge(250);
        $treeWithPleurotus->setGenus(TreeGenusesEnum::GENUS_PICEA);
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
