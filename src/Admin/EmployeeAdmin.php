<?php
declare(strict_types=1);

namespace App\Admin;

use App\Entity\Employee;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class EmployeeAdmin extends AbstractAdmin
{
    protected $translationDomain = 'SonataAdminBundle';

    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $form)
    {
        $form
            ->add('first_name', TextType::class, [
            ])
            ->add('middle_name', TextType::class, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('last_name', TextType::class, [
            ])
            ->add('age', NumberType::class)
            ->add('using_company_car', CheckboxType::class, [
                'required' => false,
                'false_values' => [false, null, '', 0],
                'value' => 1,
                'empty_data' => 0,
            ])
            ->add('base_salary', MoneyType::class, [
                'empty_data' => 0,
                'currency' => 'USD',
                'required' => false,
            ])
            ->add('kids', NumberType::class, [
                'empty_data' => 0,
                'required' => false,
            ])

        ;
    }

    protected function configureDatagridFilters(\Sonata\AdminBundle\Datagrid\DatagridMapper $filter)
    {
        $filter
            ->add('first_name')
            ->add('middle_name')
            ->add('last_name')
            ->add('age')
            ->add('using_company_car')
            ->add('base_salary')
        ;
    }

    protected function configureListFields(\Sonata\AdminBundle\Datagrid\ListMapper $list)
    {
        $list
            ->addIdentifier('full_name', 'string', [
                'label' => 'Full Name',
                'code' => 'getFullName',
            ])
            ->add('age')
            ->add('using_company_car', 'boolean', [
                'editable' => true,
            ])
            ->add('base_salary', 'currency', [
                'currency' => 'USD',
            ])
            ->add('kids', 'number')
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
