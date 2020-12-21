<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    public static $numberOfComments;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfComments = 100;

        for ($i = 1; $i <= self::$numberOfComments; ++$i) {
            $comment = new Comment();
            $comment
                ->setTitle($faker->word())
                ->setContent($faker->sentences(2, true))
                ->setValuation($faker->numberBetween(1, 5))
                ->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)))
                ->setResource($this->getReference('resource'.$faker->numberBetween(1, ResourceFixture::$numberOfResources)))
            ;
            $comment->setCommentDate($faker->dateTimeBetween('-6 months', 'now'));
            $manager->persist($comment);
            $this->addReference('comment'.$i, $comment);
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
