<?php

namespace App\DataFixtures;

use App\Entity\RelModerationUserAnswer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RelModerationUserAnswerFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 100; ++$i) {
            $relModerationUserAnswer = new RelModerationUserAnswer();
            $relModerationUserAnswer
                ->setComment('C\'est vraiment pas très gentil ce qu\'il a dit !')
                ->setModerationType($this->getReference('moderationType'.$faker->numberBetween(1, count(ModerationTypeFixture::$tabModerationType))))
                ->setModerator($this->getReference(UserFixture::$userModerator[$faker->numberBetween(0, count(UserFixture::$userModerator) - 1)]))
                ->setModerationDate($faker->dateTimeBetween('-2 years', 'now'))
                ->setAnswer($this->getReference('answer'.$faker->numberBetween(1, AnswerFixture::$numberOfAnswers)))
            ;
            $manager->persist($relModerationUserAnswer);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ModerationTypeFixture::class,
            UserFixture::class,
            AnswerFixture::class,
        ];
    }
}
