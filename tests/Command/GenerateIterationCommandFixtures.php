<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Entity\MyceliumGenusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class GenerateIterationCommandFixtures extends Fixture
{
    public const string ZONE_REFERENCE = 'zone_reference';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager)
    {
        $zone = DummiesFactory::newZone(self::ZONE_REFERENCE);
        $this->addReference(self::ZONE_REFERENCE, $zone);
        $manager->persist($zone);

        $mycelium = DummiesFactory::newMycelium($zone);
        $mycelium->setGenus(MyceliumGenusEnum::GENUS_PLEUROTUS);
        $manager->persist($mycelium);

        $manager->flush();
    }
}
