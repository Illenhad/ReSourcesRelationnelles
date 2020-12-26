<?php

namespace App\DataFixtures;

use App\Entity\ManagementType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ManagementTypeFixture extends Fixture
{
    public static $tabManagementType = [
        1 => 'Favoris',
        2 => 'Mis de côté',
        3 => 'Exploité',
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabManagementType as $managementType) {
            ++$i;
            $managementTypeEntity = new ManagementType();
            $managementTypeEntity->setLabel($managementType);
            $manager->persist($managementTypeEntity);
            $this->addReference('managementType'.$i, $managementTypeEntity);
        }

        $manager->flush();
    }
}
