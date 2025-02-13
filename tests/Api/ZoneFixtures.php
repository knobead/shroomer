<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\MyceliumGenusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\DummiesFactory;

class ZoneFixtures extends Fixture
{
    public const string USER_REFERENCE = 'user';

    public const string FIRST_ZONE_REFERENCE  = 'first_zone';
    public const string SECOND_ZONE_REFERENCE = 'second_zone';

    public const string FIRST_MYCELIUM_REFERENCE  = 'first_mycelium';
    public const string SECOND_MYCELIUM_REFERENCE = 'second_mycelium';

    public const string FIRST_TREE_REFERENCE  = 'first_tree';
    public const string SECOND_TREE_REFERENCE = 'second_tree';

    public const string FIRST_SPOROCARP_REFERENCE  = 'first_sporocarp';
    public const string SECOND_SPOROCARP_REFERENCE = 'second_sporocarp';
    public const string THIRD_SPOROCARP_REFERENCE  = 'third_sporocarp';

    public const string OTHER_USER_REFERENCE =  'other_user';
    public const string OTHER_ZONE_REFERENCE =  'other_zone';

    /**
     * Load data fixtures with the passed EntityManager
     */
    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser();
        $this->addReference(self::USER_REFERENCE, $user);

        $firstZone = DummiesFactory::newZone($user, self::FIRST_ZONE_REFERENCE);
        $this->addReference(self::FIRST_ZONE_REFERENCE, $firstZone);

        $secondZone = DummiesFactory::newZone($user, self::SECOND_ZONE_REFERENCE);
        $this->addReference(self::SECOND_ZONE_REFERENCE, $secondZone);

        $manager->persist($firstZone);
        $manager->persist($secondZone);
        $manager->persist($user);

        $firstTree = DummiesFactory::newTree($firstZone);
        $firstTree->setAge(1000);
        $this->addReference(self::FIRST_TREE_REFERENCE, $firstTree);
        $manager->persist($firstTree);

        $secondTree = DummiesFactory::newTree($secondZone);
        $secondTree->setAge(350);
        $this->addReference(self::SECOND_TREE_REFERENCE, $secondTree);
        $manager->persist($secondTree);

        $firstMycelium = DummiesFactory::newMycelium($firstTree);
        $firstMycelium->setGenus(MyceliumGenusEnum::GENUS_MORCHELLA);
        $this->addReference(self::FIRST_MYCELIUM_REFERENCE, $firstMycelium);
        $manager->persist($firstMycelium);

        $secondMycelium = DummiesFactory::newMycelium($secondTree);
        $secondMycelium->setGenus(MyceliumGenusEnum::GENUS_BOLETUS);
        $this->addReference(self::SECOND_MYCELIUM_REFERENCE, $secondMycelium);
        $manager->persist($secondMycelium);

        $firstSporocarp = DummiesFactory::newSporocarp($firstMycelium);
        $firstSporocarp->setZone($firstZone);
        $firstSporocarp->setAge(10);
        $firstSporocarp->setSize(15);
        $this->addReference(self::FIRST_SPOROCARP_REFERENCE, $firstSporocarp);
        $manager->persist($firstSporocarp);

        $secondSporocarp = DummiesFactory::newSporocarp($firstMycelium);
        $secondSporocarp->setZone($firstZone);
        $secondSporocarp->setAge(20);
        $secondSporocarp->setSize(25);
        $secondSporocarp->setEaten(true);
        $secondSporocarp->setRotten(true);
        $secondSporocarp->setWormy(true);
        $this->addReference(self::SECOND_SPOROCARP_REFERENCE, $secondSporocarp);
        $manager->persist($secondSporocarp);

        $thirdSporocarp = DummiesFactory::newSporocarp($secondMycelium);
        $thirdSporocarp->setZone($secondZone);
        $this->addReference(self::THIRD_SPOROCARP_REFERENCE, $thirdSporocarp);
        $manager->persist($thirdSporocarp);

        $otherUser = DummiesFactory::newUser(email: 'other@other.com');
        $this->addReference(self::OTHER_USER_REFERENCE, $otherUser);
        $manager->persist($otherUser);

        $otherZone = DummiesFactory::newZone($otherUser, 'other zone');
        $this->addReference(self::OTHER_ZONE_REFERENCE, $otherZone);
        $manager->persist($otherZone);

        $manager->flush();
    }
}
