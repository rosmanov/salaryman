<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\SalaryFactor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SalaryFactor|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalaryFactor|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalaryFactor[]    findAll()
 * @method SalaryFactor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method SalaryFactor[]    findById(array $ids, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaryFactorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalaryFactor::class);
    }
}
