<?php
declare(strict_types=1);

namespace App\Service\Matcher;

use App\Dto\SalaryFactorRule;
use App\Entity\Employee;
use App\Service\Matcher\SalaryFieldMatcherFactory;
use App\Service\Operator\OperatorFactory;

class SalaryFactorMatcher
{
    /**
     * @var OperatorFactory
     */
    private $operatorFactory;

    /**
     * @var SalaryFieldMatcherFactory
     */
    private $fieldMatcherFactory;

    public function __construct(
        OperatorFactory $operatorFactory,
        SalaryFieldMatcherFactory $fieldMatcherFactory
    ) {
        $this->operatorFactory = $operatorFactory;
        $this->fieldMatcherFactory = $fieldMatcherFactory;
    }

    /**
     * Checks if employee matches salary factor rule.
     *
     * @param Employee $employee
     * @param SalaryFactorRule $rule
     *
     * @return bool
     *
     * @throws \RuntimeExceptio
     */
    public function matches(Employee $employee, SalaryFactorRule $rule): bool
    {
        if ($rule->isGroup()) {
            foreach ($rule->getRules() as $childRule) {
                if (!$this->matches($employee, $childRule)) {
                    return false;
                }
            }
            return true;
        }

        if ($rule->isRule()) {
            $fieldMatcher = $this->fieldMatcherFactory->create($rule);
            return $fieldMatcher->matches($this, $employee);
        }

        throw new \RuntimeException('Invalid rule passed to ' . __METHOD__);
    }

    /**
     * Is called by a SalaryFieldMatcherInterface.
     *
     * @param Employee $employee
     * @param SalaryFactorRule $rule
     *
     * @return bool
     */
    public function matchesKidsField(Employee $employee, SalaryFactorRule $rule): bool
    {
        $ruleKids = (int) $rule->getValue();
        $employeeKids = (int) $employee->getKids();

        $operator = $this->operatorFactory->createComparisonOperator($rule->getOperator());

        return $operator->evaluate($employeeKids, $ruleKids);
    }

    /**
     * Is called by a SalaryFieldMatcherInterface.
     *
     * @param Employee $employee
     * @param SalaryFactorRule $rule
     *
     * @return bool
     */
    public function matchesAgeField(Employee $employee, SalaryFactorRule $rule): bool
    {
        $ruleAge = (int) $rule->getValue();
        $employeeAge = (int) $employee->getAge();

        $operator = $this->operatorFactory->createComparisonOperator($rule->getOperator());

        return $operator->evaluate($employeeAge, $ruleAge);
    }

    /**
     * Is called by a SalaryFieldMatcherInterface.
     *
     * @param Employee $employee
     * @param SalaryFactorRule $rule
     *
     * @return bool
     */
    public function matchesUsingCompanyCarField(Employee $employee, SalaryFactorRule $rule): bool
    {
        $ruleFlag = (bool) $rule->getValue();
        $employeeFlag = (bool) $employee->getUsingCompanyCar();

        $operator = $this->operatorFactory->createComparisonOperator($rule->getOperator());

        return $operator->evaluate($employeeFlag, $ruleFlag);
    }
}
