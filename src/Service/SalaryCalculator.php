<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Employee;
use App\Entity\SalaryFactor;
use App\Service\Operator\OperatorFactory;
use Psr\Log\LoggerInterface;
use App\Service\Matcher\SalaryFactorMatcher;

class SalaryCalculator
{
    /**
     * @var SalaryFactorSerializer
     */
    private $factorSerializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var OperatorFactory
     */
    private $operatorFactory;

    /**
     * @var SalaryFactorMatcher
     */
    private $ruleMatcher;

    public function __construct(
        SalaryFactorSerializer $factorSerializer,
        OperatorFactory $operatorFactory,
        SalaryFactorMatcher $ruleMatcher,
        LoggerInterface $logger
    ) {
        $this->factorSerializer = $factorSerializer;
        $this->operatorFactory = $operatorFactory;
        $this->ruleMatcher = $ruleMatcher;
        $this->logger = $logger;
    }

    /**
     * @param Employee $employee Employee who's salary should be calculated
     * @param SalaryFactor[] $factors
     * @return float The calculated salary based on Employee::$base_salary.
     *
     *  !!!!
     *  $salary = $salary + sum($i)($salary * $percent[$i] / 100) + sum($i)($number[$i])
     *  !!!!
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function calculate(Employee $employee, array $factors): float
    {
        $salary = $employee->getBaseSalary();

        foreach ($factors as $factor) {
            $rule = $this->factorSerializer->deserialize($factor->getRules());

            if ($this->ruleMatcher->matches($employee, $rule)) {
                $diff = $this->calculateFactorValue($factor, $employee->getBaseSalary());
                $this->logger->info(sprintf(
                    "[%s] [Diff] %f [Factor] %s",
                    $employee->getTitle(),
                    $diff,
                    $factor->getTitle()
                ));
                $salary += $diff;
            }
        }

        if ($salary < 0) {
            $this->logger->warning(
                'Protecting against running to a ' .
                " negative salary ($salary) for employee #" .
                $employee->getId()
            );
            $salary = 0;
        }

        return $salary;
    }

    /**
     * @param SalaryFactor $factor
     * @param float $baseSalary
     * @return float
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    private function calculateFactorValue(SalaryFactor $factor, float $baseSalary): float
    {
        if ($baseSalary < 0) {
            throw new \InvalidArgumentException('Base salary must be positive');
        }

        $result = 0;

        switch ($factor->getValueType()) {
            case SalaryFactor::NUMERIC_VALUE_TYPE:
                $result = $factor->getValue();
                break;
            case SalaryFactor::PERCENT_VALUE_TYPE:
                $result = $baseSalary * $factor->getValue() / 100;
                break;
            default:
                throw new \RuntimeException('Unknown factor value type: ' . $factor->getValueType());
        }

        switch ($factor->getType()) {
            case SalaryFactor::BONUS_TYPE:
                // do nothing
                break;
            case SalaryFactor::DEDUCTION_TYPE:
                if ($result > 0) {
                    $result = -$result;
                }
                break;
            default:
                throw new \RuntimeException('Unknown factor type: ' . $factor->getType());
        }

        return $result;
    }

}
