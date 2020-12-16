<?php

namespace App\DataFixtures;

use App\Entity\ActionType;
use App\Entity\ManagementType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActionTypeFixture extends Fixture
{
    private static $tabActionType = [
        1 => 'Création',
        2 => 'Consultation',
        3 => 'Validation',
        4 => 'Suspension',
        5 => 'Modification',
        6 => 'Suppression'
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::$tabActionType as $actionType) {
            $actionTypeEntity = new ActionType();
            $actionTypeEntity->setLabel($actionType);
            $manager->persist($actionTypeEntity);
        }

        $manager->flush();
    }
}
