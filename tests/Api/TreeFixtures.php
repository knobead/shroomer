<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\TreeGenusesEnum;
use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TreeFixtures extends Fixture
{
    public const string ZONE_REFERENCE = 'zone';
    public const string TREE_REFERENCE = 'tree';
    public const string USER_REFERENCE = 'user';

    public const string OTHER_USER_REFERENCE =  'other_user';
    public const string OTHER_ZONE_REFERENCE =  'other_zone';


    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser();
        $user->setResourceEntomofauna(5000);
        $user->setResourceFauna(5000);
        $user->setResourceFlora(5000);
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE, $user);

        $zone = DummiesFactory::newZone($user, self::ZONE_REFERENCE);
        $manager->persist($zone);
        $this->addReference(self::ZONE_REFERENCE, $zone);

        $tree = DummiesFactory::newTree($zone);
        $tree->setGenus(TreeGenusesEnum::GENUS_FRAXINUS);
        $tree->setAge(150);
        $manager->persist($tree);
        $this->addReference(self::TREE_REFERENCE, $tree);

        $otherUser = DummiesFactory::newUser(email: 'other@other.com');
        $otherUser->setResourceEntomofauna(50000);
        $otherUser->setResourceFlora(50000);
        $otherUser->setResourceFauna(50000);
        $this->addReference(self::OTHER_USER_REFERENCE, $otherUser);
        $manager->persist($otherUser);

        $otherZone = DummiesFactory::newZone($otherUser, 'other zone');
        $this->addReference(self::OTHER_ZONE_REFERENCE, $otherZone);
        $manager->persist($otherZone);

        $manager->flush();
    }
}
