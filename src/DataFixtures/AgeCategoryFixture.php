<?php

namespace App\DataFixtures;

use App\Entity\AgeCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AgeCategoryFixture extends Fixture
{
    public static $tabAge = [
        1 => 'Enfant (0 à 18 ans)', //0-18 junior
        2 => 'Jeune adulte (19 à 35 ans)', //18-35 adulte
        3 => 'Adulte (36 à 55 ans)', //35-55 senior
        4 => 'Senior (à partir de 56 ans)', //55+ master
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabAge as $age) {
            ++$i;
            $ageCategory = new AgeCategory();
            $ageCategory->setLabel($age);
            $manager->persist($ageCategory);
            $this->addReference('ageCategory'.$i, $ageCategory);
        }

        $manager->flush();
    }
}
