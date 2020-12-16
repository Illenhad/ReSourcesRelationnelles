<?php

namespace App\DataFixtures;

use App\Entity\AgeCategory;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AgeCategoryFixture extends Fixture
{

    public static $tabAge = [
        1 => "petit nenfant à croquer (0-18)", //0-18 junior
        2 => "jeun's qui parcourt le monde (18-35)", //18-35 adulte
        3 => "personne plus vraiment très fraiche (35-55)", //35-55 senior
        4 => "p'tits vieux tout moisi (55+)" //55+ master
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;

        foreach (self::$tabAge as $age) {
            $i++;
            $ageCategory = new AgeCategory();
            $ageCategory->setLabel($age);
            $manager->persist($ageCategory);
            $this->addReference('age'.$i, $ageCategory);
        }

        $manager->flush();

    }
}
