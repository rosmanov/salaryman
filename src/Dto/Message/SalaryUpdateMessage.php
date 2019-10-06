<?php
declare(strict_types=1);

namespace App\Dto\Message;

use App\Entity\Employee;

/**
 * Represents a message indicating that the salaries of a number of employees
 * need to be re-calculated.
 */
class SalaryUpdateMessage implements MessageInterface
{
    /**
     * @var int[]
     */
    private $employeeIds = [];

    /**
     * @param Employee $employee
     * @return self
     */
    public function addEmployee(Employee $employee): self
    {
        $this->employeeIds[] = $employee->getId();
        return $this;
    }

    /**
     * @return int[]
     */
    public function getEmployeeIds(): array
    {
        return $this->employeeIds;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return [
            'employee_ids' => $this->employeeIds,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return json_encode($this);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);
        $this->employeeIds = $data['employee_ids'] ?? [];
    }
}
