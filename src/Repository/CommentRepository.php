<?php

namespace App\Repository;

use App\Entity\Comment;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function getCurrentDayCommentNumber() {
        $manager = $this->getEntityManager();

        $query = $manager->createQuery(
            'SELECT count(c)
            FROM App\Entity\Comment c 
            WHERE c.commentDate BETWEEN :date1 AND :date2'
        )-> setParameter('date1', new DateTime('today'))
        ->setParameter('date2', new DateTime('now'));

        return $query->getScalarResult()[0][1];
    }

    public function getCurrentDayComments() {
        $manager = $this->getEntityManager();

        $query = $manager->createQuery(
            'SELECT c
            FROM App\Entity\Comment c 
            WHERE c.commentDate BETWEEN :date1 AND :date2'
        )-> setParameter('date1', new DateTime('today'))
        ->setParameter('date2', new DateTime('now'))
        ->setMaxResults(3);

        return $query->getResult();
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
