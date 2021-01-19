<?php

namespace App\DataFixtures;

use App\Entity\Resource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ResourceFixture extends Fixture implements DependentFixtureInterface
{
    public static $numberOfResources;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfResources = 500; //ne pas mettre une valeur inférieure à 60

        for ($i = 1; $i <= self::$numberOfResources; ++$i) {
            $resource = new Resource();
            $resource
                ->setTitle($faker->words(8, true))
                ->setLink($faker->url)
                ->setPublic($faker->boolean(40))
                ->setDateCreation($faker->dateTimeBetween('-2 years', 'now', null))
                ->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)))
                ->setDescription($faker->words(20, true))
                ->setActive(1)
                ->setAgeCategory($this->getReference('ageCategory'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))))
                ->setCategory($this->getReference('category'.$faker->numberBetween(1, count(CategoryFixture::$tabCategory))))
                ->setResourceType($this->getReference(('resourceType'.$faker->numberBetween(1, count(ResourceTypeFixture::$tabResourceType)))))
                ->setRelationShip($this->getReference('relationShip'.$faker->numberBetween(1, count(RelationshipFixture::$tabRelationship))))
            ;
            $manager->persist($resource);
            $this->addReference('resource'.$i, $resource);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            AgeCategoryFixture::class,
            CategoryFixture::class,
            ResourceTypeFixture::class,
            RelationshipFixture::class,
        ];
    }
}
