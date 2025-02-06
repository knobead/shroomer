<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const string USER_REFERENCE = 'user';

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setResourceFlora(2000);
        $user->setResourceFauna(500);
        $user->setResourceEntomofauna(200);
        $user->setPassword('$2y$13$wRp63dWVz0.Yce8s/aeecOmtr4eYWXBmjksYY22Qzn55SPT1YuX.q');
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('email@email.com');
        $this->addReference(self::USER_REFERENCE, $user);
        $manager->persist($user);

        $manager->flush();
    }
}
