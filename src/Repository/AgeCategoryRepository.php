<?php

namespace App\Repository;

use App\Entity\AgeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgeCategory[]    findAll()
 * @method AgeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgeCategory::class);
    }
}
