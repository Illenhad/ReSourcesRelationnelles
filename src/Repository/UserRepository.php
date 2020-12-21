<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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
            ->groupBy('u.roles')
            ->orderBy('u.roles')
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
}
