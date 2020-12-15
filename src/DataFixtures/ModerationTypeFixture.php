<?php

namespace App\DataFixtures;

use App\Entity\ModerationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModerationTypeFixture extends Fixture
{
    private static $tabModerationType = [
        1 => 'Modification',
        2 => 'Suspension'
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::$tabModerationType as $moderationType) {
            $moderationTypeEntity = new ModerationType();
            $moderationTypeEntity->setLabel($moderationType);
            $manager->persist($moderationTypeEntity);
        }

        $manager->flush();
    }
}
