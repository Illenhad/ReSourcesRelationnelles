<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    private $passwordEncoder;

    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry, User::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function findJunior()
    {
        return $this->findBy(
            ['ageCategory' => 1]
        );
    }

    public function findAdult()
    {
        return $this->findBy(
            ['ageCategory' => 2]
        );
    }

    public function findSenior()
    {
        return $this->findBy(
            ['ageCategory' => 3]
        );
    }

    public function findMaster()
    {
        return $this->findBy(
            ['ageCategory' => 4]
        );
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function countByRoles(): array
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as nbr')
            ->groupBy('u.role')
            ->orderBy('u.role')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function countByAgeCategory(): array
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as nbr')
            ->groupBy('u.ageCategory')
            ->orderBy('u.ageCategory')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $value
     *
     * @return User[] Returns an array of User objects
     *
     * @throws NonUniqueResultException
     */
    public function countByDpt($value): array
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as nbr')
            ->where('u.department = :val')
            ->setParameter(':val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @return array
     */
    public function groupByDate()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as nbr')
            ->groupBy('u.dateLastConnection')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $username
     * @param $data
     * @return string
     */
    public function changePassword(string $username, $data): string
    {
        $manager = $this->getEntityManager();

        $user = $manager->getRepository(User::class)->findOneBy([
            'username' => $username
        ]);

        if (!$this->passwordEncoder->isPasswordValid($user, $data['old_password'])) {
            return "L'ancien mot de passe n'est pas valide";
        }

        if ($data['new_password'] == $data['new_password_confirm']) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $data['new_password']));

            try {
                $manager->persist($user);
                $manager->flush();
            } catch (OptimisticLockException $e) {
                return "Un problème est survenu lors de l'enregistrement du nouveau mot de passe";
            } catch (ORMException $e) {
                return "Un problème est survenu lors de l'enregistrement du nouveau mot de passe";
            }

        } else {
            return "Saisie incorrecte : vous devez saisir deux fois le nouveau mot de passe pour le confirmer";
        }

        return "";
    }


}
