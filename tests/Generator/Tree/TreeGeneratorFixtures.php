<?php

declare(strict_types=1);

namespace App\Tests\Generator\Tree;

use App\Entity\TreeGenusesEnum;
use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TreeGeneratorFixtures extends Fixture
{
    public const FIRST_TREE_REFERENCE = 'first_tree';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $zone = DummiesFactory::newZone('zone');
        $manager->persist($zone);

        $tree = DummiesFactory::newTree($zone);
        $tree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $tree->setAge(55);
        $this->addReference(self::FIRST_TREE_REFERENCE, $tree);
        $manager->persist($tree);

        $manager->flush();
    }
}
