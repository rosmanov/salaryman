<?php
declare(strict_types=1);

namespace App\Service\Operator;

use App\Service\Operator\ComparisonOperatorInterface;

class EqualOperator implements ComparisonOperatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function evaluate($operandLeft, $operandRight): bool
    {
        return $operandLeft === $operandRight;
    }
}
