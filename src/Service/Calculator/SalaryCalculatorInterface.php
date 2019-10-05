<?php
declare(strict_types=1);

namespace App\Service\Calculator;

use App\Entity\Employee;
use App\Entity\SalaryFactor;

interface SalaryCalculatorInterface
{
    /**
     * Calculates salary of an employee. Returns the result of calculation.
     *
     * @param Employee $employee Employee who's salary should be calculated
     * @param SalaryFactor[] $factors
     * @return float The calculated salary based on Employee::$base_salary.
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function calculate(Employee $employee, array $factors): float;
}
