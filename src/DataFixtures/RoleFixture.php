<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixture extends Fixture
{

    private static $tabRole = [
    1 => "ROLE_USER",
    2 => "ROLE_MODERATEUR",
    3 => "ROLE_ADMIN",
    4 => "ROLE_SUPER_ADMIN"
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabRole as $role) {
            $i++;
            $roleEntity = new Role();
            $roleEntity
                ->setLabel($role);
            $manager->persist($roleEntity);

            $this->addReference(self::$tabRole[$i], $roleEntity);
        }

        $manager->flush();
    }
}
