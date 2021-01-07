<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public static $numberOfUsers;
    public static $userModerator;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        self::$numberOfUsers = 200;

        for ($i = 1; $i <= self::$numberOfUsers; ++$i) {
            $user = new User();
            $user
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setUsername($faker->userName)
                ->setEmail($faker->freeEmail)
                ->setDepartment($this->getReference('department'.$faker->numberBetween(1, count(DepartmentFixture::$tabDept))))
                ->setAgeCategory($this->getReference('ageCategory'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))))
                ->setDateLastConnection($faker->dateTimeBetween('-60 days', 'now', null))
                ->setRole($this->getReference('ROLE_USER'))
                ->setPassword($this->passwordEncoder->encodePassword($user, '12345678'))
                ->setActive(true)
                ->setCreationDate($faker->dateTimeBetween('-2 years', 'now', null));
            $manager->persist($user);
            $this->addReference('user'.$i, $user);
        }

        $tabModerator = [];

        $user = new User();
        $user
            ->setFirstname('Louis')
            ->setLastname('Delarose')
            ->setUsername('beaugossedu62')
            ->setEmail('beaugossedu62@hotmail.fr')
            ->setDepartment($this->getReference('department'.$faker->numberBetween(1, count(DepartmentFixture::$tabDept))))
            ->setAgeCategory($this->getReference('ageCategory'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_MODERATEUR'))
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'))
            ->setActive(true)
            ->setCreationDate($faker->dateTimeBetween('-2 years', 'now', null))
        ;
        $manager->persist($user);
        ++self::$numberOfUsers;
        $this->addReference('user'.self::$numberOfUsers, $user);
        array_push($tabModerator, 'user'.self::$numberOfUsers);

        $user = new User();
        $user
            ->setFirstname('Jacqueline')
            ->setLastname('Dumont')
            ->setUsername('mamienova')
            ->setEmail('mamienova@gmail.fr')
            ->setDepartment($this->getReference('department'.$faker->numberBetween(1, count(DepartmentFixture::$tabDept))))
            ->setAgeCategory($this->getReference('ageCategory'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_MODERATEUR'))
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'))
            ->setActive(true)
            ->setCreationDate($faker->dateTimeBetween('-2 years', 'now', null))
        ;
        $manager->persist($user);
        ++self::$numberOfUsers;
        $this->addReference('user'.self::$numberOfUsers, $user);
        array_push($tabModerator, 'user'.self::$numberOfUsers);

        $user = new User();
        $user
            ->setFirstname('Jeanne')
            ->setLastname('Faitlecafe')
            ->setUsername('jeaaaanne')
            ->setEmail('jeanne@cafe.fr')
            ->setDepartment($this->getReference('department'.$faker->numberBetween(1, count(DepartmentFixture::$tabDept))))
            ->setAgeCategory($this->getReference('ageCategory'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_ADMIN'))
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'))
            ->setActive(true)
            ->setCreationDate($faker->dateTimeBetween('-2 years', 'now', null))
        ;
        $manager->persist($user);
        ++self::$numberOfUsers;
        $this->addReference('user'.self::$numberOfUsers, $user);
        array_push($tabModerator, 'user'.self::$numberOfUsers);

        $user = new User();
        $user
            ->setFirstname('Jean-Michel')
            ->setLastname('Lebosse')
            ->setUsername('bigboss')
            ->setEmail('jeanmichel.leboss@gmail.fr')
            ->setDepartment($this->getReference('department'.$faker->numberBetween(1, count(DepartmentFixture::$tabDept))))
            ->setAgeCategory($this->getReference('ageCategory'.$faker->numberBetween(1, count(AgeCategoryFixture::$tabAge))))
            ->setDateLastConnection(new \DateTime('now'))
            ->setRole($this->getReference('ROLE_SUPER_ADMIN'))
            ->setPassword($this->passwordEncoder->encodePassword($user, 'admin'))
            ->setActive(true)
            ->setCreationDate($faker->dateTimeBetween('-2 years', 'now', null))
        ;
        $manager->persist($user);
        ++self::$numberOfUsers;
        $this->addReference('user'.self::$numberOfUsers, $user);
        array_push($tabModerator, 'user'.self::$numberOfUsers);

        self::$userModerator = $tabModerator;

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixture::class,
            DepartmentFixture::class,
            AgeCategoryFixture::class,
        ];
    }
}
