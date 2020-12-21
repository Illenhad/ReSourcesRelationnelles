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

        for ($i = 0; $i < 20; ++$i) {
            $relModerationUser = new RelModerationUser();
            $relModerationUser->setModerationType($this->getReference('moderationType'.$faker->numberBetween(1, count(ModerationTypeFixture::$tabModerationType))));
            $relModerationUser->setModerationDate($faker->dateTimeBetween('-60 days', 'now'));
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
            UserFixture::class,
        ];
    }
}
