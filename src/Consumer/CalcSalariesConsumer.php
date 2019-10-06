<?php
declare(strict_types=1);

namespace App\Consumer;

use App\Dto\Message\SalaryFactorUpdateMessage;
use App\Dto\Message\SalaryUpdateMessage;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Repository\SalaryFactorRepository;
use App\Service\Calculator\SalaryCalculatorInterface;
use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class CalcSalariesConsumer implements ConsumerInterface
{
    /**
     * Max. number of employees to fetch from database in a single query.
     *
     * @var int
     */
    private const EMPLOYEE_STEP = 100;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepo;

    /**
     * @var SalaryFactorRepository
     */
    private $salaryFactorRepo;

    /**
     * @var SalaryCalculatorInterface
     */
    private $calculator;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        EntityManager $entityManager,
        EmployeeRepository $employeeRepo,
        SalaryFactorRepository $salaryFactorRepo,
        SalaryCalculatorInterface $calculator,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->employeeRepo = $employeeRepo;
        $this->salaryFactorRepo = $salaryFactorRepo;
        $this->calculator = $calculator;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(AMQPMessage $msg)
    {
        $this->logger->debug(__METHOD__);
        try {
            $object = unserialize($msg->body);
            //$this->logger->debug('>> Received object of type: ' . get_class($object));

            if ($object instanceof SalaryUpdateMessage) {
                $this->processEmployees($object->getEmployeeIds());
            } elseif ($object instanceof SalaryFactorUpdateMessage) {
                $this->processFactors($object->getFactorIds());
            } else {
                $this->logger->warning(
                    'Received unknown object type: ' . get_class($object) .
                    ' message body: ' . $msg->body
                );
                return true;
            }
        } catch (\Throwable $e) {
            $this->logger->error(
                'Caught ' . get_class($e) . ': ' . $e->getMessage()
                //'. Backtrace: ' . $e->getTraceAsString()
            );
            // TODO: add an error counter + a listener that would stop infinite logging
            // Re-schedule message
            return false;
        }
    }

    /**
     * @param int[] $employeeIds
     */
    private function processEmployees(array $employeeIds): void
    {
        $this->logger->debug(__METHOD__);
        $factors = $this->salaryFactorRepo->findAll();
        if (!$factors) {
            return;
        }
        $numFactors = count($factors);

        for ($offset = 0; $offset < $numFactors; $offset += self::EMPLOYEE_STEP) {
            $ids = array_slice($employeeIds, $offset, self::EMPLOYEE_STEP);
            $employees = $this->employeeRepo->findById($ids, null, self::EMPLOYEE_STEP, $offset);
            if (!$employees) {
                break;
            }

            foreach ($employees as $employee) {
                $salary = $this->calculator->calculate($employee, $factors);
                $employee->setActualSalary($salary);
                $this->entityManager->persist($employee);

                $this->logger->info(sprintf(
                    'Salary for employee #%d changed from %f %4$s to %f %4$s',
                    $employee->getId(),
                    $employee->getBaseSalary(),
                    $employee->getActualSalary(),
                    $employee->getSalaryCurrencyCode()
                ));
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param int[] $factorIds
     */
    private function processFactors($factorIds): void
    {
        $this->logger->debug(__METHOD__);
        $factors = $this->salaryFactorRepo->findById($factorIds);
        if (!$factors) {
            return;
        }

        foreach ($this->getAllEmployees() as $employee) {
            $this->logger->debug(__METHOD__ . ' employees - 1');
            $salary = $this->calculator->calculate($employee, $factors);
            $employee->setActualSalary($salary);
            $this->entityManager->persist($employee);

            $this->logger->info(sprintf(
                'Salary for employee #%d changed from %f %4$s to %f %4$s',
                $employee->getId(),
                $employee->getBaseSalary(),
                $employee->getActualSalary(),
                $employee->getSalaryCurrencyCode()
            ));
        }

        $this->entityManager->flush();
    }

    /**
     * @return \Generator|Employee[]
     */
    private function getAllEmployees()
    {
        $this->logger->debug(__METHOD__);
        for ($offset = 0 ;; $offset += self::EMPLOYEE_STEP) {
            $this->logger->debug(__METHOD__ . ' - offset ' . $offset);
            $employees = $this->employeeRepo->findBy([], null, self::EMPLOYEE_STEP, $offset);
            if (!$employees) {
                break;
            }
            yield from $employees;
        }
    }
}
