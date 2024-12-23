<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class ZoneFixtures extends Fixture
{
    public const string FIRST_ZONE_REFERENCE  = 'first_zone';
    public const string SECOND_ZONE_REFERENCE = 'second_zone';

    public const string FIRST_MYCELIUM_REFERENCE  = 'first_mycelium';
    public const string SECOND_MYCELIUM_REFERENCE = 'second_mycelium';

    public const string FIRST_TREE_REFERENCE  = 'first_tree';
    public const string SECOND_TREE_REFERENCE = 'second_tree';

    public const string FIRST_SPOROCARP_REFERENCE  = 'first_sporocarp';
    public const string SECOND_SPOROCARP_REFERENCE = 'second_sporocarp';
    public const string THIRD_SPOROCARP_REFERENCE  = 'third_sporocarp';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $firstZone = DummiesFactory::newZone(self::FIRST_ZONE_REFERENCE);
        $this->addReference(self::FIRST_ZONE_REFERENCE, $firstZone);
        $manager->persist($firstZone);

        $secondZone = DummiesFactory::newZone(self::SECOND_ZONE_REFERENCE);
        $this->addReference(self::SECOND_ZONE_REFERENCE, $secondZone);
        $manager->persist($secondZone);

        $firstTree = DummiesFactory::newTree($firstZone);
        $this->addReference(self::FIRST_TREE_REFERENCE, $firstTree);
        $manager->persist($firstTree);

        $secondTree = DummiesFactory::newTree($secondZone);
        $this->addReference(self::SECOND_TREE_REFERENCE, $secondTree);
        $manager->persist($secondTree);

        $firstMycelium = DummiesFactory::newMycelium($firstTree);
        $this->addReference(self::FIRST_MYCELIUM_REFERENCE, $firstMycelium);
        $manager->persist($firstMycelium);

        $secondMycelium = DummiesFactory::newMycelium($secondTree);
        $this->addReference(self::SECOND_MYCELIUM_REFERENCE, $secondMycelium);
        $manager->persist($secondMycelium);

        $firstSporocarp = DummiesFactory::newSporocarp($firstMycelium, self::FIRST_SPOROCARP_REFERENCE);
        $firstSporocarp->setZone($firstZone);
        $firstSporocarp->setAge(10);
        $firstSporocarp->setSize(15);
        $this->addReference(self::FIRST_SPOROCARP_REFERENCE, $firstSporocarp);
        $manager->persist($firstSporocarp);

        $secondSporocarp = DummiesFactory::newSporocarp($firstMycelium, self::SECOND_SPOROCARP_REFERENCE);
        $secondSporocarp->setZone($firstZone);
        $secondSporocarp->setDikarya(sprintf('%s %s', $firstMycelium->getGenus()->value, 'erythropus'));
        $secondSporocarp->setAge(20);
        $secondSporocarp->setSize(25);
        $secondSporocarp->setEaten(true);
        $secondSporocarp->setRotten(true);
        $secondSporocarp->setWormy(true);
        $this->addReference(self::SECOND_SPOROCARP_REFERENCE, $secondSporocarp);
        $manager->persist($secondSporocarp);

        $thirdSporocarp = DummiesFactory::newSporocarp($secondMycelium, self::THIRD_SPOROCARP_REFERENCE);
        $thirdSporocarp->setZone($secondZone);
        $this->addReference(self::THIRD_SPOROCARP_REFERENCE, $thirdSporocarp);
        $manager->persist($thirdSporocarp);

        $manager->flush();
    }
}
