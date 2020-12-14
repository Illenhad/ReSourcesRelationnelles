<?php

namespace App\DataFixtures;

use App\Entity\ShareGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ShareGroupFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $shareGroup = new ShareGroup();
            $shareGroup
                ->setLabel($faker->words(3, true))
                ->setComment($faker->sentence);
            $manager->persist($shareGroup);
        }

        $manager->flush();
    }
}
