<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class ZoneFixtures extends Fixture
{
    public const FIRST_ZONE_REFERENCE  = 'first_zone';
    public const SECOND_ZONE_REFERENCE = 'second_zone';

    public const FIRST_SPOROCARP_REFERENCE  = 'first_sporocarp';
    public const SECOND_SPOROCARP_REFERENCE = 'second_sporocarp';
    public const THIRD_SPOROCARP_REFERENCE  = 'third_sporocarp';

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

        $firstSporocarp = DummiesFactory::newSporocarp(self::FIRST_SPOROCARP_REFERENCE);
        $firstSporocarp->setZone($firstZone);
        $firstSporocarp->setAge(10);
        $firstSporocarp->setSize(15);
        $this->addReference(self::FIRST_SPOROCARP_REFERENCE, $firstSporocarp);
        $manager->persist($firstSporocarp);

        $secondSporocarp = DummiesFactory::newSporocarp(self::SECOND_SPOROCARP_REFERENCE);
        $secondSporocarp->setZone($firstZone);
        $secondSporocarp->setAge(20);
        $secondSporocarp->setSize(25);
        $secondSporocarp->setEaten(true);
        $secondSporocarp->setRotten(true);
        $secondSporocarp->setWormy(true);
        $this->addReference(self::SECOND_SPOROCARP_REFERENCE, $secondSporocarp);
        $manager->persist($secondSporocarp);

        $thirdSporocarp = DummiesFactory::newSporocarp(self::THIRD_SPOROCARP_REFERENCE);
        $thirdSporocarp->setZone($secondZone);
        $this->addReference(self::THIRD_SPOROCARP_REFERENCE, $thirdSporocarp);
        $manager->persist($thirdSporocarp);

        $manager->flush();
    }
}
