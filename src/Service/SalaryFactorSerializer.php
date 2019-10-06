<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\SalaryFactorRule;
use App\Dto\SalaryFactorRuleBuilder;

class SalaryFactorSerializer
{
    private const CONDITION_KEY = 'condition';
    private const RULES_KEY = 'rules';
    private const TYPE_KEY = 'type';
    private const ID_KEY = 'id';
    private const FIELD_KEY = 'field';
    private const OPERATOR_KEY = 'operator';
    private const VALUE_KEY = 'value';

    /**
     * @param string|array JSON string or an array (deserialized JSON) of salary factor rules
     * @throws \InvalidArgumentException
     */
    public function deserialize($json): SalaryFactorRule
    {
        if (is_string($json)) {
            $rules = json_decode($json, true);
        } elseif (is_array($json)) {
            $rules = $json;
        }
        if (!(isset($rules) && is_array($rules))) {
            throw new \InvalidArgumentException(var_export($rules, true));
        }

        $builder = new SalaryFactorRuleBuilder();

        // Empty array is considered a valid rule group with no rules
        // (special case for conditionless rules such as "Country tax")
        if (empty($rules)) {
            return $builder
                ->setCondition('AND')
                ->setRules([])
                ->build();
            ;
        }

        if ($this->isValidGroup($rules)) {
            $builder->setCondition($rules[self::CONDITION_KEY]);
            $rules = $rules[self::RULES_KEY];
        }

        foreach ($rules as $rule) {
            if (!is_array($rule)) {
                throw new \RuntimeException(
                    "Invalid rules entry found in JSON ($json): " . json_encode($rule)
                );
            }

            if ($this->isValidGroup($rule)) {
                $child_rule = $this->deserialize($rule);
                $builder->addRule($child_rule);
            } elseif ($this->isValidRule($rule)) {
                $singleRuleBulider = new SalaryFactorRuleBuilder();
                $singleRuleBulider
                    ->setId($rule[self::ID_KEY])
                    ->setType($rule[self::TYPE_KEY])
                    ->setField($rule[self::FIELD_KEY])
                    ->setOperator($rule[self::OPERATOR_KEY])
                    ->setValue($rule[self::VALUE_KEY])
                ;
                $builder->addRule($singleRuleBulider->build());
            } else {
                throw new \InvalidArgumentException(
                    "Invalid rules entry found in JSON ($json): " . json_encode($rule)
                );
            }
        }

        return $builder->build();
    }

    /**
     * Returns true, if $rule is a valid salary factor rule group
     *
     * @return bool
     */
    private function isValidGroup(array $rule): bool
    {
        return isset($rule[self::CONDITION_KEY]) && isset($rule[self::RULES_KEY]);
    }

    /**
     * Returns true, if $rule is a valid salary factor rule (group item)
     *
     * @return bool
     */
    private function isValidRule(array $rule): bool
    {
        return isset($rule[self::ID_KEY]) && isset($rule[self::TYPE_KEY]);
    }
}
