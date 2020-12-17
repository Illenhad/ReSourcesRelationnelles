<?php

namespace App\DataFixtures;

use App\Entity\ModerationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModerationTypeFixture extends Fixture
{
    public static $tabModerationType = [
        1 => 'Modification',
        2 => 'Suspension',
        3 => 'Annulation suspension'
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabModerationType as $moderationType) {
            $i++;
            $moderationTypeEntity = new ModerationType();
            $moderationTypeEntity->setLabel($moderationType);
            $manager->persist($moderationTypeEntity);
            $this->addReference('moderationType'.$i, $moderationTypeEntity);
        }

        $manager->flush();
    }
}
