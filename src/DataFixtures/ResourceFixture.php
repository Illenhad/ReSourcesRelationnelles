<?php

namespace App\DataFixtures;

use App\Entity\Resource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ResourceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 150; $i++) {
            $resource  = new Resource();
            $resource
                ->setTitle($faker->words(3, true))
                ->setLink($faker->url)
                ->setPublic($faker->boolean(40))
                ->setDateCreation($faker->dateTimeBetween('-6 months', 'now', null));
            $manager->persist($resource);
        }

        $manager->flush();
    }
}
