<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $comment = new Comment();
            $comment
                ->setTitle($faker->word())
                ->setContent($faker->sentences(2, true))
                ->setValuation($faker->numberBetween(1, 5));
            $manager->persist($comment);
        }

        $manager->flush();
    }
}
