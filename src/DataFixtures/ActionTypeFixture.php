<?php

namespace App\DataFixtures;

use App\Entity\ActionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActionTypeFixture extends Fixture
{
    public static $tabActionType = [
        1 => 'Création',
        2 => 'Consultation',
        3 => 'Validation',
        4 => 'Suspension',
        5 => 'Modification',
        6 => 'Suppression',
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabActionType as $actionType) {
            ++$i;
            $actionTypeEntity = new ActionType();
            $actionTypeEntity->setLabel($actionType);
            $manager->persist($actionTypeEntity);
            $this->addReference('actionType'.$i, $actionTypeEntity);
        }

        $manager->flush();
    }
}
