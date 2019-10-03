<?php
declare(strict_types=1);

namespace App\Admin;

use App\Entity\Employee;
use App\Entity\SalaryFactor;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class SalaryFactorAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'name',
    ];
    protected $translationDomain = 'SonataAdminBundle';

    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $form)
    {
        $form
            ->add('name', TextType::class, [ ])
            ->add('rules', TextareaType::class, [
                'attr' => [
                    'class' => 'js-salary_factor js-querybuilder',
                ]
            ])
            ->add('type', ChoiceFieldMaskType::class, [
                'choices' => [
                    'Bonus' => SalaryFactor::BONUS_TYPE,
                    'Deduction' => SalaryFactor::DEDUCTION_TYPE,
                ]
            ])
            ->add('value_type', ChoiceType::class, [
                'choices' => [
                    'Numeric' => SalaryFactor::NUMERIC_VALUE_TYPE,
                    'Percent' => SalaryFactor::PERCENT_VALUE_TYPE,
                ]
            ])
            ->add('value', NumberType::class)
        ;
    }

    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('type')
            ->add('value_type')
        ;
    }

    protected function configureListFields(\Sonata\AdminBundle\Datagrid\ListMapper $list)
    {
        $list
            ->addIdentifier('name', 'string')
            ->add('type', 'choice', [
                'choices' => [
                    'Bonus' => SalaryFactor::BONUS_TYPE,
                    'Deduction' => SalaryFactor::DEDUCTION_TYPE,
                ]
            ])
            ->add('value_type', 'choice', [
                    'Numeric' => SalaryFactor::NUMERIC_VALUE_TYPE,
                    'Percent' => SalaryFactor::PERCENT_VALUE_TYPE,
            ])
            ->add('value', 'number', [
                'editable' => true,
            ])
        ;
    }

    public function toString($object)
    {
        if ($object instanceof Employee) {
            return $object->getTitle();
        }
        return 'Employee';
    }
}
