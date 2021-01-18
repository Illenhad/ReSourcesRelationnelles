<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public static $tabCategory = [
        1 => 'Communication',
        2 => 'Cultures',
        3 => 'Développement personnel',
        4 => 'Intelligence émotionnelle',
        5 => 'Loisirs',
        6 => 'Monde professionnel',
        7 => 'Parentalité',
        8 => 'Qualité de vie',
        9 => 'Recherche de sens',
        10 => 'Santé physique',
        11 => 'Santé psychique',
        12 => 'Spiritualité',
        13 => 'Vie affective',
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabCategory as $category) {
            ++$i;
            $categoryEntity = new Category();
            $categoryEntity->setLabel($category);
            $manager->persist($categoryEntity);
            $this->addReference('category'.$i, $categoryEntity);
        }

        $manager->flush();
    }
}
