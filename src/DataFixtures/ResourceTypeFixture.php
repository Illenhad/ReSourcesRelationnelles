<?php

namespace App\DataFixtures;

use App\Entity\ResourceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ResourceTypeFixture extends Fixture
{
    private static $tabResourceType = [
        1 => 'Activité / Jeu à réaliser',
        2 => 'Article',
        3 => 'Carte Défi',
        4 => 'Cours au format PDF',
        5 => 'Exercice / Atelier',
        6 => 'Fiche de lecture',
        7 => 'Jeu en ligne',
        8 => 'Vidéo'
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::$tabResourceType as $resourceType) {
            $resourceTypeEntity = new ResourceType();
            $resourceTypeEntity->setLabel($resourceType);
            $manager->persist($resourceTypeEntity);
        }

        $manager->flush();
    }
}
