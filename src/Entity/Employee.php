<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $middle_name = '';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="boolean")
     */
    private $using_company_car = false;

    /**
     * @ORM\Column(type="float")
     */
    private $base_salary;

    /**
     * @ORM\Column(type="float")
     */
    private $actual_salary;

    /**
     * @ORM\Column(type="integer")
     */
    private $kids = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTimeInterface
     */
    private $modified;

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

    public function getMiddleName(): string
    {
        return $this->middle_name ?? '';
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

    public function setModified(?\DateTimeInterface $modified): self
    {
        $this->modified = $modified;
        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }


    public function getSalaryCurrencyCode():  string
    {
        return 'USD';
    }

    /**
     * Returns full name of the person
     *
     * TODO: Person name formatting is actually a complicated task. But we'll
     * simply concatenate the name parts, since this is not particularly
     * important for this project.
     *
     * @return string
     */
    public function getFullName() : string
    {
        return $this->first_name . ' '
            . ($this->middle_name ? "$this->middle_name " : '')
            . $this->last_name;
    }

    /**
     * Returns a title suitable for display in the admin panel
     *
     * @return string
     */
    public function getTitle() : string
    {
        return sprintf('Employee «%s»', $this->getFullName());
    }

    public function __toString()
    {
        return $this->getTitle() ?: '';
    }
}
