<?php

namespace App\DataFixtures;

use App\Entity\RelSharedResourceUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelSharedResourceUserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 250; $i++) {
            $relSharedResourceUser = new RelSharedResourceUser();
            $relSharedResourceUser->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relSharedResourceUser->setSharerUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setSharedWithUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $manager->persist($relSharedResourceUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {

        return [
            UserFixture::class,
            ResourceFixture::class
        ];

    }
}
