<?php

declare(strict_types=1);

namespace App\Tests\Generator\Sporocarp;

use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SporocarpGeneratorFixtures extends Fixture
{
    public const string SPOROCARP_REFERENCE = 'sporocarp';
    public const string SECOND_SPOROCARP_REFERENCE = 'second_sporocarp';
    public const string THIRD_SPOROCARP_REFERENCE = 'third_sporocarp';
    public const string FOURTH_SPOROCARP_REFERENCE = 'fourth_sporocarp';
    public const string FIFTH_SPOROCARP_REFERENCE = 'fifth_sporocarp';

    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser();
        $manager->persist($user);

        $zone = DummiesFactory::newZone($user, 'zone');
        $manager->persist($zone);
        $tree = DummiesFactory::newTree($zone);
        $manager->persist($tree);
        $mycelium = DummiesFactory::newMycelium($tree);
        $manager->persist($mycelium);

        $sporocarp = DummiesFactory::newSporocarp($mycelium);
        $sporocarp->setZone($zone);
        $sporocarp->setAge(15);
        $sporocarp->setSize(10);
        $sporocarp->setRotten(false);
        $sporocarp->setEaten(false);
        $sporocarp->setWormy(false);
        $this->addReference(self::SPOROCARP_REFERENCE, $sporocarp);
        $manager->persist($sporocarp);

        $secondSporocarp = DummiesFactory::newSporocarp($mycelium);
        $secondSporocarp->setZone($zone);
        $secondSporocarp->setAge(2);
        $secondSporocarp->setSize(10);
        $secondSporocarp->setRotten(false);
        $secondSporocarp->setEaten(false);
        $secondSporocarp->setWormy(false);
        $this->addReference(self::SECOND_SPOROCARP_REFERENCE, $secondSporocarp);
        $manager->persist($secondSporocarp);

        $thirdSporocarp = DummiesFactory::newSporocarp($mycelium);
        $thirdSporocarp->setZone($zone);
        $thirdSporocarp->setAge(10);
        $thirdSporocarp->setSize(110);
        $thirdSporocarp->setRotten(false);
        $thirdSporocarp->setEaten(true);
        $thirdSporocarp->setWormy(true);
        $this->addReference(self::THIRD_SPOROCARP_REFERENCE, $thirdSporocarp);
        $manager->persist($thirdSporocarp);

        $fourthSporocarp = DummiesFactory::newSporocarp($mycelium);
        $fourthSporocarp->setZone($zone);
        $fourthSporocarp->setAge(13);
        $fourthSporocarp->setSize(10);
        $fourthSporocarp->setRotten(true);
        $fourthSporocarp->setEaten(false);
        $fourthSporocarp->setWormy(false);
        $this->addReference(self::FOURTH_SPOROCARP_REFERENCE, $fourthSporocarp);
        $manager->persist($fourthSporocarp);

        $fifthSporocarp = DummiesFactory::newSporocarp($mycelium);
        $fifthSporocarp->setZone($zone);
        $fifthSporocarp->setAge(10);
        $fifthSporocarp->setRotten(false);
        $fifthSporocarp->setEaten(true);
        $fifthSporocarp->setWormy(true);
        $this->addReference(self::FIFTH_SPOROCARP_REFERENCE, $fifthSporocarp);
        $manager->persist($fifthSporocarp);

        $manager->flush();
    }
}
