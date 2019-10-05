<?php
declare(strict_types=1);

namespace App\Admin;

use App\Entity\Employee;
use App\Repository\SalaryFactorRepository;
use App\Service\Calculator\SalaryCalculatorInterface;
use Psr\Log\LoggerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class EmployeeAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $translationDomain = 'SonataAdminBundle';

    /**
     * @var SalaryCalculatorInterface
     */
    private $salaryCalculator;

    /**
     * @var SalaryFactorRepository
     */
    private $salaryFactorRepo;

    /**
     * @var LoggerInterface
     */
    private $logger;

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
            ->add('actual_salary', MoneyType::class, [
                'empty_data' => 0,
                'currency' => 'USD',
                'required' => false,
                'disabled' => true,
                'help' => 'Is calculated automatically based on the Salary Factors',
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
            ->add('actual_salary')
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
            ->add('actual_salary', 'currency', [
                'currency' => 'USD',
                'label' => 'Salary',
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

    /**
     * Is called via dependency injection hooks (see config/services.yaml).
     *
     * @param SalaryCalculatorInterface $salaryCalculator
     */
    public function setSalaryCalculator(SalaryCalculatorInterface $salaryCalculator): void
    {
        $this->salaryCalculator = $salaryCalculator;
    }

    /**
     * Is called via dependency injection hooks (see config/services.yaml).
     *
     * @param SalaryFactorRepository $salaryFactorRepo
     */
    public function setSalaryFactorRepository(SalaryFactorRepository $salaryFactorRepo): void
    {
        $this->salaryFactorRepo = $salaryFactorRepo;
    }

    /**
     * Is called via dependency injection hooks (see config/services.yaml).
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($object)
    {
        $this->updateSalary($object);
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($object)
    {
        $this->updateSalary($object);
    }

    /**
     * Is called from preUpdate and prePersist methods.
     */
    private function updateSalary(Employee $employee): void
    {
        /**
         * @todo perform calculations in a background job. (Send a message to some
         * message queue such as RabbitMQ.)
         */
        $factors = $this->salaryFactorRepo->findAll();
        $salary = $this->salaryCalculator->calculate($employee, $factors);
        $this->logger->debug("Updating employee salary to $salary, employee #" . $employee->getId());
        $employee->setActualSalary($salary);
    }
}
