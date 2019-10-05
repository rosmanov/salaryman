<?php
declare(strict_types=1);

namespace App\Service\Operator;

interface OperatorInterface
{
    /**
     * Applies the operator to the provided operand values as follows:
     * $operandLeft OPERATOR $operandRight
     *
     * Returns the result of the OPERATOR evaluation.
     *
     * @return mixed
     */
    public function evaluate($operandLeft, $operandRight);
}
