<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\TreeGenusesEnum;
use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TreeFixtures extends Fixture
{
    public const ZONE_REFERENCE = 'zone';
    public const TREE_REFERENCE = 'tree';
    public const USER_REFERENCE = 'user';


    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser();
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE, $user);

        $zone = DummiesFactory::newZone(self::ZONE_REFERENCE);
        $manager->persist($zone);
        $this->addReference(self::ZONE_REFERENCE, $zone);

        $tree = DummiesFactory::newTree($zone);
        $tree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $tree->setAge(150);
        $tree->setSize(200);
        $manager->persist($tree);
        $this->addReference(self::TREE_REFERENCE, $tree);

        $manager->flush();
    }
}
