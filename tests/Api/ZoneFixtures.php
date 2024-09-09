<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class ZoneFixtures extends Fixture
{
    public const FIRST_GARDEN_REFERENCE  = 'first_garden';
    public const SECOND_GARDEN_REFERENCE = 'second_garden';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $firstGarden = DummiesFactory::newZone(self::FIRST_GARDEN_REFERENCE);
        $secondGarden = DummiesFactory::newZone(self::SECOND_GARDEN_REFERENCE);
        $this->addReference(self::FIRST_GARDEN_REFERENCE, $firstGarden);
        $this->addReference(self::SECOND_GARDEN_REFERENCE, $secondGarden);
        $manager->persist($firstGarden);
        $manager->persist($secondGarden);

        $manager->flush();
    }
}
