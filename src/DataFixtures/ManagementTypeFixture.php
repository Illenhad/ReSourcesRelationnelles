<?php

namespace App\DataFixtures;

use App\Entity\ManagementType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ManagementTypeFixture extends Fixture
{
    /**private static $tabManagementType = [
        1 => 'Validation',
        2 => 'Suspension',
        3 => 'Modification',
        4 => 'Suppression'
    ];*/

    private static $tabManagementType = [
        1 => 'Favoris',
        2 => 'Mis de côté',
        3 => 'Exploité'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::$tabManagementType as $managementType) {
            $managementTypeEntity = new ManagementType();
            $managementTypeEntity->setLabel($managementType);
            $manager->persist($managementTypeEntity);
        }

        $manager->flush();
    }
}
