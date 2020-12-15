<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i <100; $i++ ) {
            $user = new User();
            $user
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setUsername($faker->userName)
                ->setEmail($faker->freeEmail)
                ->setDepartment($this->getReference('Ain'))
                ->setDateLastConnection($faker->dateTimeBetween('-60 days', 'now', null))
                ->setRoles($this->getReference('ROLE_USER'))
                ->setPassword("12345678");
            $manager->persist($user);
        }

        $user
            ->setFirstname('Louis')
            ->setLastname('Delarose')
            ->setUsername('beaugossedu62')
            ->setEmail('beaugossedu62@hotmail.fr')
            ->setDepartment($this->getReference('Ain'))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRoles($this->getReference('ROLE_MODERATEUR'))
            ->setPassword("12345678")
        ;
        $manager->persist($user);

        $user
            ->setFirstname('Jacqueline')
            ->setLastname('Dumont')
            ->setUsername('mamienova')
            ->setEmail('mamienova@gmail.fr')
            ->setDepartment($this->getReference('Ain'))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRoles($this->getReference('ROLE_MODERATEUR'))
            ->setPassword("12345678")
        ;
        $manager->persist($user);

        $user
            ->setFirstname('Jeanne')
            ->setLastname('Faitlecafe')
            ->setUsername('jeaaaanne')
            ->setEmail('jeanne@cafe.fr')
            ->setDepartment($this->getReference('Ain'))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRoles($this->getReference('ROLE_ADMIN'))
            ->setPassword("12345678")
        ;
        $manager->persist($user);

        $user
            ->setFirstname('Jean-Michel')
            ->setLastname('Lebosse')
            ->setUsername('bigboss')
            ->setEmail('jeanmichel.leboss@gmail.fr')
            ->setDepartment($this->getReference('Ain'))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRoles($this->getReference('ROLE_SUPER_ADMIN'))
            ->setPassword("12345678")
        ;
        $manager->persist($user);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixture::class
        ];
    }
}
