<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Employee[]    findById(array $ids, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * Marks the actual salary "inconsistent" for all employees.
     */
    public function resetActualSalary(): void
    {
        $query = $this->getEntityManager()->createQuery(
            'UPDATE ' . Employee::class . '
            e SET e.actual_salary = :actual_salary'
        );
        $query->setParameter(
            'actual_salary',
            Employee::getSalaryInconsistentValue(),
            \PDO::PARAM_INT
        );
        $query->execute();
    }
}
