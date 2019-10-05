<?php
declare(strict_types=1);

namespace App\Service\Matcher;

use App\Entity\Employee;
use App\Service\Matcher\SalaryFactorMatcher;

interface SalaryFieldMatcherInterface
{
    /**
     * Checks if the salary factor field matches employee properties.
     *
     * @param SalaryFactorMatcher $factorMatcher
     * @param Employee $employee
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function matches(SalaryFactorMatcher $factorMatcher, Employee $employee): bool;
}

