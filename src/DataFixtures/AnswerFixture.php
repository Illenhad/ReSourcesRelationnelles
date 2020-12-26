<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnswerFixture extends Fixture implements DependentFixtureInterface
{
    public static $numberOfAnswers;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfAnswers = 300;

        for ($i = 1; $i <= self::$numberOfAnswers; ++$i) {
            $answer = new Answer();
            $answer
                ->setComment($this->getReference('comment'.$faker->numberBetween(1, CommentFixture::$numberOfComments)))
                ->setContent($faker->sentences(1, true))
                ->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)))
                ->setAnswerDate($faker->dateTimeBetween('-2 years', 'now'));
            $manager->persist($answer);
            $this->addReference('answer'.$i, $answer);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            CommentFixture::class,
        ];
    }
}
