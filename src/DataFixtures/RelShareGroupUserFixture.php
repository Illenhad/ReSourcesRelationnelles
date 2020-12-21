<?php

namespace App\DataFixtures;

use App\Entity\RelShareGroupUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelShareGroupUserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 100; ++$i) {
            $relShareGroupUser = new RelShareGroupUser();
            $relShareGroupUser->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relShareGroupUser->setCreator(false);
            $relShareGroupUser->setShareGroup($this->getReference('shareGroup'.$faker->numberBetween(1, ShareGroupFixture::$numberOfShareGroup)));
            $manager->persist($relShareGroupUser);
        }

        for ($i = 1; $i <= ShareGroupFixture::$numberOfShareGroup; ++$i) {
            $relShareGroupUser = new RelShareGroupUser();
            $relShareGroupUser->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relShareGroupUser->setCreator(true);
            $relShareGroupUser->setShareGroup($this->getReference('shareGroup'.$i));
            $manager->persist($relShareGroupUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            ShareGroupFixture::class,
        ];
    }
}
