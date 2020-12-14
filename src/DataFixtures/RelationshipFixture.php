<?php

namespace App\DataFixtures;

use App\Entity\RelationshipType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RelationshipFixture extends Fixture
{
    private static $tabRelationship = [
        1 => 'Soi',
        2 => 'Conjoints',
        3 => 'Famille - enfants',
        4 => 'Famille - parents',
        5 => 'Famille - fratrie',
        6 => 'Professionnel - collègues',
        7 => 'Professionnel - collaborateurs',
        8 => 'Professionnel - manager'
        ];

    public function load(ObjectManager $manager)
    {

        foreach (self::$tabRelationship as $relationship) {
            $relationshipEntity = new RelationshipType();
            $relationshipEntity->setLabel($relationship);
            $manager->persist($relationshipEntity);
        }

        $manager->flush();
    }
}
