<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"editable"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"editable"})
     */
    private $middle_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"editable"})
     */
    private $last_name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"editable"})
     */
    private $age;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"editable"})
     */
    private $using_company_car = false;

    /**
     * @ORM\Column(type="float")
     * @Groups({"editable"})
     */
    private $base_salary;

    /**
     * @ORM\Column(type="float")
     */
    private $actual_salary;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"editable"})
     */
    private $kids = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(string $middle_name): self
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getUsingCompanyCar(): ?bool
    {
        return $this->using_company_car;
    }

    public function setUsingCompanyCar(bool $using_company_car): self
    {
        $this->using_company_car = $using_company_car;

        return $this;
    }

    public function getBaseSalary(): ?float
    {
        return $this->base_salary;
    }

    public function setBaseSalary(float $base_salary): self
    {
        $this->base_salary = $base_salary;

        return $this;
    }

    public function getActualSalary(): ?float
    {
        return $this->actual_salary;
    }

    public function setActualSalary(float $actual_salary): self
    {
        $this->actual_salary = $actual_salary;

        return $this;
    }

    public function getKids(): ?int
    {
        return $this->kids;
    }

    public function setKids(int $kids): self
    {
        $this->kids = $kids;

        return $this;
    }
}
