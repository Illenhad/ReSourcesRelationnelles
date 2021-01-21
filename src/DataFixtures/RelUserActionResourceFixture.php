<?php

namespace App\DataFixtures;

use App\Entity\RelUserActionResource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelUserActionResourceFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 300; ++$i) {
            $relUserActionResource = new RelUserActionResource();
            $relUserActionResource->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relUserActionResource->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relUserActionResource->setActionDate($faker->dateTimeBetween('-2 years', 'now'));
            $relUserActionResource->setActionType($this->getReference('actionType'.$faker->numberBetween(1, count(ActionTypeFixture::$tabActionType))));
            $manager->persist($relUserActionResource);
        }

        //consultation de ressources
        for ($i = 1; $i <= 500; ++$i) {
            $relUserActionResource = new RelUserActionResource();
            $relUserActionResource->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relUserActionResource->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relUserActionResource->setActionDate($faker->dateTimeBetween('-2 years', 'now'));
            $relUserActionResource->setActionType($this->getReference('actionType'.'2'));
            $manager->persist($relUserActionResource);
        }

        //consultation de ressources sur la journée
        for ($i = 1; $i <= 20; ++$i) {
            $relUserActionResource = new RelUserActionResource();
            $relUserActionResource->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relUserActionResource->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relUserActionResource->setActionDate(new \DateTime('now'));
            $relUserActionResource->setActionType($this->getReference('actionType'.'2'));
            $manager->persist($relUserActionResource);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActionTypeFixture::class,
            UserFixture::class,
            ResourceFixture::class,
        ];
    }
}
