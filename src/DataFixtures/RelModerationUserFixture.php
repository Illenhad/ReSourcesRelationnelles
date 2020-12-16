<?php

namespace App\DataFixtures;

use App\Entity\RelModerationUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelModerationUserFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $relModerationUser = new RelModerationUser();
            $relModerationUser->setModerationType($this->getReference('Modification'));
            $relModerationUser->setModerationDate($faker->dateTimeBetween('-30 days', 'now'));
            $relModerationUser->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relModerationUser->setModerator($this->getReference(UserFixture::$userModerator[$faker->numberBetween(0, count(UserFixture::$userModerator) - 1)]));
            $manager->persist($relModerationUser);
        }

        for ($i = 0; $i < 5; $i++) {
            $relModerationUser = new RelModerationUser();
            $relModerationUser->setModerationType($this->getReference('Suspension'));
            $relModerationUser->setModerationDate(new \dateTime('now'));
            $relModerationUser->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $relModerationUser->setModerator($this->getReference(UserFixture::$userModerator[$faker->numberBetween(0, count(UserFixture::$userModerator) - 1)]));
            $manager->persist($relModerationUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ModerationTypeFixture::class,
            UserFixture::class
        ];
    }
}
