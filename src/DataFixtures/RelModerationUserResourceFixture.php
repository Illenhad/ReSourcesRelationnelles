<?php

namespace App\DataFixtures;

use App\Entity\RelModerationUserResource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelModerationUserResourceFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 150; ++$i) {
            $relModerationUserResource = new RelModerationUserResource();
            $relModerationUserResource->setModerationDate($faker->dateTimeBetween('-2 years', 'now'));
            $relModerationUserResource->setModerator($this->getReference(UserFixture::$userModerator[$faker->numberBetween(0, count(UserFixture::$userModerator) - 1)]));
            $relModerationUserResource->setModerationType($this->getReference('moderationType'.$faker->numberBetween(1, count(ModerationTypeFixture::$tabModerationType))));
            $relModerationUserResource->setComment('Cette resource est nulle');
            $relModerationUserResource->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $manager->persist($relModerationUserResource);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            ResourceFixture::class,
            ModerationTypeFixture::class,
        ];
    }
}
