<?php
declare(strict_types=1);

namespace App\Dto;

/**
 * Builds instances of SalaryFactorRule
 */
class SalaryFactorRuleBuilder
{
    use SalaryFactorRuleTrait;

    /**
     * @throws \InvalidArgumentException
     */
    public function build(): SalaryFactorRule
    {
        if (!$this->isValid()) {
            throw new \InvalidArgumentException(
                'Salary factor rule is invalid: '  . var_export($this, true)
            );
        }
        return new SalaryFactorRule($this);
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setField(?string $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function setOperator(?string $operator): self
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @param string|int|null $value
     */
    public function setValue($value): self
    {
        $this->value= $value;
        return $this;
    }

    /**
     * @param SalaryFactorRule[] $rules
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    public function addRule(SalaryFactorRule $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function setCondition(?string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }
}
