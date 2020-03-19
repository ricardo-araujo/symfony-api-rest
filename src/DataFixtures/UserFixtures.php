<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUserName('user');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$DpaRUp1jTCrCZK2t+4UgkA$zhaWZXjsoV9yoX7ZQ4x5PUI4kSfU7WaxnMqnNvwADUM');

        $manager->persist($user);
        $manager->flush();
    }
}
