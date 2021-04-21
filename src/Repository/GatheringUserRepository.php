<?php

namespace App\Repository;

use App\Entity\GatheringUser;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GatheringUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method GatheringUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method GatheringUser[]    findAll()
 * @method GatheringUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GatheringUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GatheringUser::class);
    }

    /**
     * @return int
     */
    public function getNumberOfGatheringUserByUser(User $user)
    {
        $query = $this->createQueryBuilder('gu')
            ->select('count(gu.id)')
            ->andWhere('gu.User = :user')
            ->setParameter('user', $user);
        return $query->getQuery()->getSingleScalarResult();
    }

    public function getGatheringNumMembersByGatheringId(int $gatheringId, ManagerRegistry $registry) {
        $gatheringUserRepository = new GatheringUserRepository($registry);
        $query = $this->createQueryBuilder('gu')
            ->select('count(gu.id)')
            ->andWhere('gu.Gathering = :gathering')
            ->setParameter('gathering', $gatheringId)
        ;
        $membercount = $query->getQuery()->getSingleScalarResult();
        return $membercount;
    }
}
