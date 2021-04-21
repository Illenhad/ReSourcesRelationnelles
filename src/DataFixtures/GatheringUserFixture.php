<?php

namespace App\DataFixtures;
use App\Entity\GatheringUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GatheringUserFixture extends Fixture implements DependentFixtureInterface
{
    public static $numberOfGatheringUser = 60;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $k = 1;
        for ($i = 1; $i <= GatheringUserFixture::$numberOfGatheringUser; ++$i) {
            for ($j = 1; $j <= $faker->numberBetween(3, 30); ++$j) {
                $gatheringUser = new GatheringUser();
                $gatheringUser
                    ->setRole(($j == 1) ? 'ADMIN' : 'MEMBER')
                    ->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)))
                    ->setGathering($this->getReference('gathering'.$i));
                $manager->persist($gatheringUser);
                $this->addReference('gatheringUser'.$k, $gatheringUser);
                $k++;
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            GatheringFixture::class,
        ];
    }
}
