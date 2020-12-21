<?php

namespace App\DataFixtures;

use App\Entity\ShareGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ShareGroupFixture extends Fixture
{
    public static $numberOfShareGroup;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfShareGroup = 20;

        for ($i = 1; $i <= self::$numberOfShareGroup; ++$i) {
            $shareGroup = new ShareGroup();
            $shareGroup
                ->setLabel($faker->words(3, true))
                ->setComment($faker->sentence);
            $manager->persist($shareGroup);
            $this->addReference('shareGroup'.$i, $shareGroup);
        }

        $manager->flush();
    }
}
