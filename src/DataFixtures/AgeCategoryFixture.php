<?php

namespace App\DataFixtures;

use App\Entity\AgeCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AgeCategoryFixture extends Fixture
{
    public static $tabAge = [
        1 => 'padawan', //0-18 junior
        2 => 'jedi', //18-35 adulte
        3 => 'maitre jedi', //35-55 senior
        4 => 'maitre Yoda', //55+ master
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
