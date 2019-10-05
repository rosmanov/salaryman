<?php
declare(strict_types=1);

namespace App\Service\Matcher;

use App\Dto\SalaryFactorRule;
use App\Entity\Employee;

class SalaryFieldMatcherFactory
{
    /**
     * @param SalaryFactorRule $rule
     *
     * @return SalaryFieldMatcherInterface
     *
     * @throws \RuntimeException
     */
    public function create(SalaryFactorRule $rule): SalaryFieldMatcherInterface
    {
        switch ($rule->getField()) {
            case Employee::AGE_FIELD:
                return new SalaryAgeFieldMatcher($rule);
            case Employee::KIDS_FIELD:
                return new SalaryKidsFieldMatcher($rule);
            case Employee::USING_COMPANY_CAR_FIELD:
                return new SalaryUsingCompanyCarFieldMatcher($rule);
            default:
                throw new \RuntimeException('Unknown factor rule field ' . $rule->getField());
        }
    }
}
