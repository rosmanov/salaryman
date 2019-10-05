<?php
declare(strict_types=1);

namespace App\Service\Matcher;

use App\Dto\SalaryFactorRule;
use App\Entity\Employee;
use App\Service\Matcher\SalaryFactorMatcher;

class SalaryUsingCompanyCarFieldMatcher implements SalaryFieldMatcherInterface
{
    /**
     * @var SalaryFactorRule
     */
    private $rule;

    public function __construct(SalaryFactorRule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * {@inheritDoc}
     */
    public function matches(SalaryFactorMatcher $factorMatcher, Employee $employee): bool
    {
        return $factorMatcher->matchesUsingCompanyCarField($employee, $this->rule);
    }
}
