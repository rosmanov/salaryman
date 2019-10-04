<?php
declare(strict_types=1);

namespace App\Admin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Represents a form control for building salary factor rules
 * using QueryBuilder.
 */
class SalaryFactorsType extends AbstractType
{
    public function getParent()
    {
        return TextareaType::class;
    }
}
