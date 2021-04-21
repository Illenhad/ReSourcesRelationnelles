<?php

namespace App\Repository;

use App\Entity\ResourceUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResourceUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceUser[]    findAll()
 * @method ResourceUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceUser::class);
    }

    public function getNumberOfShareResource(int $userId) {
        $query = $this->createQueryBuilder('ru')
            ->select('count(ru.id)')
            ->orWhere('ru.sharing_user = :userId')
            ->orWhere('ru.user = :userId')
            ->setParameter('userId', $userId)
        ;
        $count = $query->getQuery()->getSingleScalarResult();
        return $count;
    }

    public function getShareResources(int $userId) {
        $query = $this->createQueryBuilder('ru')
            ->orWhere('ru.sharing_user = :userId')
            ->orWhere('ru.user = :userId')
            ->setParameter('userId', $userId)
        ;
        return $query->getQuery()->getResult();
    }

    public function getById(int $id) {
        $query = $this->createQueryBuilder('ru')
            ->andWhere('ru.id = :id')
            ->setParameter('id', $id)
        ;
        return $query->getQuery()->getResult();
    }
}
