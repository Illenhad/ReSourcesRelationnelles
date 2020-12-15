<?php

namespace App\DataFixtures;

use App\Entity\ActionType;
use App\Entity\ManagementType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActionTypeFixture extends Fixture
{
    private static $tabActionType = [
        1 => 'Consultation',
        2 => 'Validation',
        3 => 'Suspension',
        4 => 'Modification',
        5 => 'Suppression'
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
