<?php

namespace App\DataFixtures;

use App\Entity\RelationshipType;
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
        self::$numberOfResources = 15;

        for ($i = 1; $i <= 150; $i++) {
            $resource = new Resource();
            $resource
                ->setTitle($faker->words(3, true))
                ->setLink($faker->url)
                ->setPublic($faker->boolean(40))
                ->setDateCreation($faker->dateTimeBetween('-6 months', 'now', null));
            $resource->setUser($this->getReference('user'.$faker->numberBetween(1, UserFixture::$numberOfUsers)));
            $resource->setAgeCategory($this->getReference('age'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))));
            $resource->setCategory($this->getReference('category'.$faker->numberBetween(1, count(CategoryFixture::$tabCategory))));
            $resource->setResourceType($this->getReference(('resourceType'.$faker->numberBetween(1, count(ResourceTypeFixture::$tabResourceType)))));
            $resource->setRelationShip($this->getReference('relationShip'.$faker->numberBetween(1, count(RelationshipFixture::$tabRelationship))));
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
            RelationshipFixture::class
        ];
    }
}
