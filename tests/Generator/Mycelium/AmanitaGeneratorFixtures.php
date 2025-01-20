<?php

declare(strict_types=1);

namespace App\Tests\Generator\Mycelium;

use App\Entity\MyceliumGenusEnum;
use App\Entity\TreeGenusesEnum;
use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AmanitaGeneratorFixtures extends Fixture
{
    public const AMANITA_MYCELIUM_REFERENCE = 'amanita-mycelium';

    public function load(ObjectManager $manager)
    {
        $zone = DummiesFactory::newZone('zone');
        $manager->persist($zone);

        $tree = DummiesFactory::newTree($zone);
        $tree->setGenus(TreeGenusesEnum::GENUS_CASTANEA);
        $manager->persist($tree);

        $amanitaMyc = DummiesFactory::newMycelium($tree);
        $amanitaMyc->setGenus(MyceliumGenusEnum::GENUS_AMANITA);
        $manager->persist($amanitaMyc);
        $this->addReference(self::AMANITA_MYCELIUM_REFERENCE, $amanitaMyc);

        $manager->flush();
    }
}
