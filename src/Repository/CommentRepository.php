<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\User;
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

    /**
     * @param User $user
     * @return mixed
     */
    public function getNumberOfComments(User $user)
    {
        $manager = $this->getEntityManager();
        $query = $manager->createQuery(
            'SELECT COUNT(r) FROM App\Entity\Comment r
                WHERE r.user = :user'
        )
            ->setParameter('user', $user);

        return $query->getScalarResult()[0][1];
    }
}
