<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $user = new User();

        for ($i = 0; $i <100; $i++ ) {
            $user
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setUsername($faker->userName)
                ->setEmail($faker->freeEmail)
                ->setDepartment($faker->numberBetween(1, 101))
                ->setDateLastConnection($faker->dateTimeBetween('-60 days', 'now', null))
                ->setRole($this->getReference('ROLE_USER'));
            $manager->persist($user);
        }

        $user
            ->setFirstname('Louis')
            ->setLastname('Delarose')
            ->setUsername('beaugossedu62')
            ->setEmail('beaugossedu62@hotmail.fr')
            ->setDepartment(62)
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_MODERATEUR'));
        $manager->persist($user);

        $user
            ->setFirstname('Jacqueline')
            ->setLastname('Dumont')
            ->setUsername('mamienova')
            ->setEmail('mamienova@gmail.fr')
            ->setDepartment(75)
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_MODERATEUR'));
        $manager->persist($user);

        $user
            ->setFirstname('Jeanne')
            ->setLastname('Faitlecafe')
            ->setUsername('jeaaaanne')
            ->setEmail('jeanne@cafe.fr')
            ->setDepartment(59)
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_ADMIN'));
        $manager->persist($user);

        $user
            ->setFirstname('Jean-Michel')
            ->setLastname('Lebosse')
            ->setUsername('bigboss')
            ->setEmail('jeanmichel.leboss@gmail.fr')
            ->setDepartment(59)
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_SUPER_ADMIN'));
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
