<?php
declare(strict_types=1);

namespace App\Service\Operator;

use App\Service\Operator\ComparisonOperatorInterface;
use App\Service\Operator\EqualOperator;
use App\Service\Operator\GreaterOperator;
use App\Service\Operator\GreaterOrEqualOperator;
use App\Service\Operator\LessOperator;
use App\Service\Operator\LessOrEqualOperator;

class OperatorFactory
{
    /**
     * @param string $name Operator name
     * @throws \InvalidArgumentException
     * @return ComparisonOperatorInterface
     */
    public function createComparisonOperator(string $name): ComparisonOperatorInterface
    {
        switch ($name) {
            case 'equal':
                return new EqualOperator();
            case 'not_equal':
                return new NotEqualOperator();
            case 'less':
                return new LessOperator();
            case 'less_or_equal':
                return new LessOrEqualOperator();
            case 'greater':
                return new GreaterOperator();
            case 'greater_or_equal':
                return new GreaterOrEqualOperator();
            default:
                throw new \InvalidArgumentException("Unknown operator name $name");
        }
    }
}
