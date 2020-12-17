<?php

namespace App\DataFixtures;

use App\Entity\RelUserActionResource;
use App\Entity\Resource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelUserActionResourceFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 100; $i++) {
            $relUserActionResource = new RelUserActionResource();
            $relUserActionResource->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relUserActionResource->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relUserActionResource->setActionDate($faker->dateTimeBetween('-3 months', 'now'));
            $relUserActionResource->setActionType($this->getReference('actionType'.$faker->numberBetween(1, count(ActionTypeFixture::$tabActionType))));
            $manager->persist($relUserActionResource);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActionTypeFixture::class,
            UserFixture::class,
            ResourceFixture::class
        ];
    }
}
