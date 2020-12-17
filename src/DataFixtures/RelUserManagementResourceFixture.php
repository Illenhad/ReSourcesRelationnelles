<?php

namespace App\DataFixtures;

use App\Entity\ManagementType;
use App\Entity\RelUserManagementResource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelUserManagementResourceFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 200; $i++) {
            $relUserManagementResource = new RelUserManagementResource();
            $relUserManagementResource->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relUserManagementResource->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relUserManagementResource->setManagementType($this->getReference('managementType'.$faker->numberBetween(1, count(ManagementTypeFixture::$tabManagementType))));
            $manager->persist($relUserManagementResource);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            ResourceFixture::class,
            ManagementTypeFixture::class
        ];
    }
}
