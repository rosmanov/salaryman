<?php
namespace App\Tests;

use App\Entity\Employee;
use App\Entity\SalaryFactor;
use App\Service\Calculator\SalaryCalculator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalaryCalculatorTest extends WebTestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
    }

    public function testCalculateAgeEquals()
    {
        $employee = new Employee();
        $employee
            ->setAge(20)
            ->setBaseSalary(1000)
        ;

        $ageFactorRules = <<<'JSON'
{
    "condition": "AND",
    "rules": [
        {
            "id": "age",
            "field": "age",
            "type": "integer",
            "input": "number",
            "operator": "equal",
            "value": 20
        }
    ],
    "valid": true
}
JSON;
        $ageFactor = new SalaryFactor();
        $ageFactor
            ->setName("Age Factor")
            ->setType(SalaryFactor::BONUS_TYPE)
            ->setValue(500)
            ->setValueType(SalaryFactor::NUMERIC_VALUE_TYPE)
            ->setRules($ageFactorRules)
        ;

        $factors[] = $ageFactor;

        $calculator = self::$container->get(SalaryCalculator::class);
        $salary = $calculator->calculate($employee, $factors);
        $this->assertEquals($salary, 1500);
    }

    public function testCalculatePercentDeduction()
    {
        $employee = new Employee();
        $employee
            ->setKids(1)
            ->setBaseSalary(5000)
        ;

        $ageFactorRules = <<<'JSON'
{
    "condition": "AND",
    "rules": [
        {
            "id": "kids",
            "field": "kids",
            "type": "integer",
            "input": "number",
            "operator": "less_or_equal",
            "value": 1
        }
    ],
    "valid": true
}
JSON;
        $ageFactor = new SalaryFactor();
        $ageFactor
            ->setName('Percent deduction Factor')
            ->setType(SalaryFactor::DEDUCTION_TYPE)
            ->setValue(10)
            ->setValueType(SalaryFactor::PERCENT_VALUE_TYPE)
            ->setRules($ageFactorRules)
        ;
        $factors[] = $ageFactor;

        $calculator = self::$container->get(SalaryCalculator::class);
        $salary = $calculator->calculate($employee, $factors);
        $this->assertEquals($salary, 4500);

        $employee->setKids(2);
        $salary = $calculator->calculate($employee, $factors);
        $this->assertEquals($salary, 5000);
    }

    public function testCalculatePercentCompex()
    {
        $employee = new Employee();
        $employee
            ->setKids(2)
            ->setAge(33)
            ->setBaseSalary(5000)
        ;

        $ageFactorRules = <<<'JSON'
{
    "condition": "OR",
    "rules": [
        {
            "id": "kids",
            "field": "kids",
            "type": "integer",
            "input": "number",
            "operator": "greater",
            "value": 1
        },
        {
            "condition": "AND",
            "rules": [
                {
                    "id": "kids",
                    "field": "kids",
                    "type": "integer",
                    "input": "number",
                    "operator": "greater_or_equal",
                    "value": 2
                },
                {
                    "id": "age",
                    "field": "age",
                    "type": "integer",
                    "input": "number",
                    "operator": "greater_or_equal",
                    "value": 33
                }
            ]
        }
    ],
    "valid": true
}
JSON;
        $ageFactor = new SalaryFactor();
        $ageFactor
            ->setName('Percent Complex Bonus Factor')
            ->setType(SalaryFactor::BONUS_TYPE)
            ->setValue(10)
            ->setValueType(SalaryFactor::PERCENT_VALUE_TYPE)
            ->setRules($ageFactorRules)
        ;
        $factors[] = $ageFactor;

        $calculator = self::$container->get(SalaryCalculator::class);
        $salary = $calculator->calculate($employee, $factors);
        $this->assertEquals($salary, 5500.0);

        $employee->setAge(30);
        $salary = $calculator->calculate($employee, $factors);
        $this->assertEquals($salary, 5500.0);
    }
}
