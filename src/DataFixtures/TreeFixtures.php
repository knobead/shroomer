<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tree;
use App\Entity\TreeGenusesEnum;
use App\Entity\Zone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TreeFixtures extends Fixture implements DependentFixtureInterface
{
    private ObjectManager $manager;

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $zoneOne = $this->getReference(ZoneFixtures::ZONE_ONE_REFERENCE, Zone::class);
        $this->populateZone($zoneOne, 4);
        $manager->persist($zoneOne);

        $zoneTwo = $this->getReference(ZoneFixtures::ZONE_TWO_REFERENCE, Zone::class);
        $this->populateZone($zoneTwo, 10);
        $manager->persist($zoneOne);

        $manager->flush();
    }

    /**
     * @param Zone $zone
     * @param int  $count
     *
     * @return void
     */
    public function populateZone(Zone $zone, int $count): void
    {
        $genuses = TreeGenusesEnum::cases();

        for ($i = 0; $i <= $count; $i++) {
            $tree = new Tree();
            $tree->setZone($zone);
            $tree->setAge(rand(10, 200));
            $tree->setGenus($genuses[array_rand($genuses)]);
            $this->manager->persist($tree);
        }
    }

    /**
     * @return class-string[]
     */
    public function getDependencies(): array
    {
        return [ZoneFixtures::class];
    }
}
