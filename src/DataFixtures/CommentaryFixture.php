<?php

namespace App\DataFixtures;
use App\Entity\Commentary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentaryFixture extends Fixture implements DependentFixtureInterface
{
    public static $numberOfCommentaries;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfCommentaries = 200;

        for ($i = 1; $i <= self::$numberOfCommentaries; ++$i) {
            $commentary = new Commentary();
            $commentary
                ->setContent($faker->sentences(2, true))
                ->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)))
                ->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)));
            $commentary->setCommentDate($faker->dateTimeBetween('-2 years', 'now'));
            $manager->persist($commentary);
            $this->addReference('commentary'.$i, $commentary);
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
