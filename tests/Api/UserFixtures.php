<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\DummiesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    public function load(ObjectManager $manager): void
    {
        $user = DummiesFactory::newUser(email: 'existing@user.com');
        $this->addReference(self::USER_REFERENCE, $user);
        $manager->persist($user);
        $manager->flush();
    }
}
