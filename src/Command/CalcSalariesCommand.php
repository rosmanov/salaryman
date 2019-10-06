<?php
declare(strict_types=1);

namespace App\Command;

use App\Repository\EmployeeRepository;
use App\Repository\SalaryFactorRepository;
use App\Service\Calculator\SalaryCalculator;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalcSalariesCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:calc-salaries';

    /**
     * @var EmployeeRepository
     */
    private $employeeRepo;

    /**
     * @var SalaryFactorRepository
     */
    private $factorRepo;

    /**
     * @var SalaryCalculator
     */
    private $calculator;

    /**
     * The number of employee rows in a batch.
     *
     * @var int
     */
    private const EMPLOYEE_STEP = 100;

    public function __construct(
        SalaryCalculator $salaryCalculator,
        EmployeeRepository $employeeRepo,
        SalaryFactorRepository $salaryFactorRepo
    ) {
        parent::__construct();

        $this->calculator = $salaryCalculator;
        $this->employeeRepo = $employeeRepo;
        $this->factorRepo = $salaryFactorRepo;
    }

    protected function configure()
    {
        $this
            ->setDescription('Calculates salaries')
            ->setHelp('Calculates salaries according to the salary factors. '
                . 'Salary factors are applied to the employee base salary '
                . 'and saved to employee.actual_salary.')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $entityManager = $this->getEntityManager();

        try {
            $factors = $this->factorRepo->findBy([], []);
            if (!$factors) {
                $io->getErrorStyle()->warning(
                    'No salary factors found. ' .
                    'Employee salaries are left untouched!'
                );
                return 1;
            }

            $count = $this->employeeRepo->count([]);
            if (!$count) {
                $io->getErrorStyle()->warning('No employees found. Aborting.');
                return 1;
            }
            $io->progressStart($count);

            for ($offset = 0 ;; $offset += self::EMPLOYEE_STEP) {
                $employees = $this->employeeRepo->findBy([], null, self::EMPLOYEE_STEP, $offset);
                if (!$employees) {
                    break;
                }
                $io->title('Processing ' . count($employees) . ' employees');

                foreach ($employees as $employee) {
                    $io->section($employee->getTitle());
                    $salary = $this->calculator->calculate($employee, $factors);
                    $employee->setActualSalary($salary);
                    $io->text(sprintf(
                        'Salary for employee #%d changed from %f %4$s to %f %4$s',
                        $employee->getId(),
                        $employee->getBaseSalary(),
                        $employee->getActualSalary(),
                        $employee->getSalaryCurrencyCode()
                    ));
                    $entityManager->persist($employee);
                }

                $entityManager->flush();
                $io->progressAdvance(count($employees));
            }
        } catch (\Throwable $e) {
            $io->getErrorStyle()->error(
                'Caught ' . get_class($e) .': ' . $e->getMessage() .
                '\n' . $e->getTraceAsString()
            );
            return 2;
        }

        $io->progressFinish();

        return 0;
    }

    private function getEntityManager(): ObjectManager
    {
        /**
         * @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
         */
        $doctrine = $this->getContainer()->get('doctrine');
        return $doctrine->getManager();
    }
}
