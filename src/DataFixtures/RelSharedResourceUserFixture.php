<?php

namespace App\DataFixtures;

use App\Entity\RelSharedResourceUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelSharedResourceUserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 1000; ++$i) {
            $relSharedResourceUser = new RelSharedResourceUser();
            $relSharedResourceUser->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relSharedResourceUser->setSharerUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setSharedWithUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setShareDate($faker->dateTimeBetween('-2 years', 'now', null));
            $manager->persist($relSharedResourceUser);
        }

        for ($i = 1; $i <= 20; ++$i) {
            $relSharedResourceUser = new RelSharedResourceUser();
            $relSharedResourceUser->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relSharedResourceUser->setSharerUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setSharedWithUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setShareDate(new \DateTime('now'));
            $manager->persist($relSharedResourceUser);
        }

        for ($i = 1; $i <= 1000; ++$i) {
            $relSharedResourceUser = new RelSharedResourceUser();
            $relSharedResourceUser->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $relSharedResourceUser->setSharerUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setSharedWithUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relSharedResourceUser->setShareDate($faker->dateTimeBetween('-7 days', 'now', null));
            $manager->persist($relSharedResourceUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            ResourceFixture::class,
        ];
    }
}
