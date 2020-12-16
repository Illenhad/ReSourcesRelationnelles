<?php

namespace App\Repository;

use App\Entity\AgeCategory;
use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class AgeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgeCategory::class);
    }
}
