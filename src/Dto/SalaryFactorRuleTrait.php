<?php
declare(strict_types=1);

namespace App\Dto;

/**
 * Fields common to SalaryFactorRule and SalaryFactorRuleBuilder
 */
trait SalaryFactorRuleTrait
{
    /**
     * Unique identifier of the filter.
     *
     * Required, if not a group.
     *
     * @var string|null
     */
    private $id;

    /**
     * Field used by the filter, multiple filters can use the same field.
     *
     * @var string|null
     */
    private $field;

    /**
     * Type of the field. Available types are string, integer, double, date, time, datetime and boolean.
     *
     * Required, if not a group.
     *
     * @var string|null
     */
    private $type;

    /**
     * Array of operators types to use for this filter. If empty the filter
     * will use all applicable operators.
     *
     * @var string|null
     */
    private $operator;

    /**
     * @var string|int|null
     */
    private $value;

    /**
     * If this instance represents a group of rules,
     * then this array is non-empty, and the rule-specific properties
     * (such as id, field, type, operator, and value) are unspecified.
     *
     * @var SalaryFactorRule[]
     */
    private $rules = [];

    /**
     * For a group, a condition operator ('AND'/'OR').
     * Otherwise, null.
     *
     * @var string|null
     */
    private $condition;


    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function isGroup(): bool
    {
        return isset($this->condition) && isset($this->rules);
    }

    public function isRule(): bool
    {
        return isset($this->id) && isset($this->type);
    }

    public function isValid(): bool
    {
        return $this->isRule() || $this->isGroup();
    }
}
