<?php
declare(strict_types=1);

namespace App\Dto;

/**
 * Represents either a salary factor rule, or a group of salary factor rules.
 *
 * This data transfer object plays a role of a convenience wrapper around the
 * JSON data generated by jQuery QueryBuilder on the front end.
 *
 * @see https://querybuilder.js.org/
 */
class SalaryFactorRule
{
    use SalaryFactorRuleTrait;

    /**
     * Should not be invoked directly
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(SalaryFactorRuleBuilder $builder)
    {
        if (!$builder->isValid()) {
            throw new \InvalidArgumentException();
        }

        $this->condition = $builder->getCondition();
        $this->rules = $builder->getRules();
        $this->value = $builder->getValue();
        $this->operator = $builder->getOperator();
        $this->type = $builder->getType();
        $this->field = $builder->getField();
        $this->id = $builder->getId();
    }
}