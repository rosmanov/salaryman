<?php
declare(strict_types=1);

namespace App\Admin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * Represents a form control for the actual salary
 */
class ActualSalaryType extends AbstractType
{
    public function getParent()
    {
        return MoneyType::class;
    }
}
