<?php

namespace App\DataFixtures;

use App\Entity\AgeCategory;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AgeCategoryFixture extends Fixture
{

    private static $tabAge = [
        1 => "0-18",
        2 => "18-35",
        3 => "35-55",
        4 => "55 +"
    ];

    public function load(ObjectManager $manager)
    {


        $label = "junior";
        $ageCategory = new AgeCategory();
        $ageCategory->setLabel($label);
        $this->addReference("junior", $ageCategory);


        $manager->persist($ageCategory);


        $label = "adult";
        $ageCategory = new AgeCategory();
        $ageCategory->setLabel($label);


        $manager->persist($ageCategory);


        $label = "senior";
        $ageCategory = new AgeCategory();
        $ageCategory->setLabel($label);


        $manager->persist($ageCategory);


        $label = "master";
        $ageCategory = new AgeCategory();
        $ageCategory->setLabel($label);

        $manager->persist($ageCategory);
        $manager->flush();
    }
}
