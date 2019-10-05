<?php
declare(strict_types=1);

namespace App\Service\Operator;

interface ComparisonOperatorInterface extends OperatorInterface
{
    /**
     * {@inheritDoc}
     *
     * @return bool
     */
    public function evaluate($operandLeft, $operandRight): bool;
}
