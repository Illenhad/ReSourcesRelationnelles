<?php

namespace App\DataFixtures;

use App\Entity\Gathering;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GatheringFixture extends Fixture
{
    public static $numberOfGatherings;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfGatherings = 60;
        for ($i = 1; $i <= self::$numberOfGatherings; ++$i) {
            $gatheringEntity = new Gathering();
            $gatheringEntity
                ->setName($faker->words(8, true));
            $manager->persist($gatheringEntity);

            $this->addReference('gathering'.$i, $gatheringEntity);
        }

        $manager->flush();
    }
}
