<?php

namespace App\DataFixtures;

use App\Entity\RelModerationUserComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelModerationUserCommentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 15; $i++) {
            $relModerationUserComment = new RelModerationUserComment();
            $relModerationUserComment
                ->setModerationDate($faker->dateTimeBetween('-50 days', 'now'))
                ->setModerator($this->getReference(UserFixture::$userModerator[$faker->numberBetween(0, count(UserFixture::$userModerator) - 1)]))
                ->setModerationType($this->getReference('moderationType'.$faker->numberBetween(1, count(ModerationTypeFixture::$tabModerationType))))
                ->setResourceComment($this->getReference('comment'.$faker->numberBetween(1, CommentFixture::$numberOfComments)));
            $manager->persist($relModerationUserComment);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            ModerationTypeFixture::class,
            CommentFixture::class
        ];
    }
}
