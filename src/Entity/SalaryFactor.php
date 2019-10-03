<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a factor affecting the salary.
 *
 * @ORM\Entity(repositoryClass="App\Repository\SalaryFactorRepository")
 */
class SalaryFactor
{
    /**
     * "Bonus" factor type (plus)
     */
    public const BONUS_TYPE = 1;
    /**
     * "Deduction" factor type (munis)
     */
    public const DEDUCTION_TYPE = 2;

    /**
     * When `value_type` field equals to NUMERIC_VALUE_TYPE,
     * the `value` field is interpreted as a number of currency units.
     */
    public const NUMERIC_VALUE_TYPE = 1;

    /**
     * When `value_type` field equals to PERCENT_VALUE_TYPE,
     * the `value` field is interpreted as a percents.
     */
    public const PERCENT_VALUE_TYPE = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int|null
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name = "";

    /**
     * JSON data built with QueryBuilder (https://querybuilder.js.org/)
     *
     * @ORM\Column(type="text")
     */
    private $rules = '{}';

    /**
     * Salary factor type. One of *_TYPE constants.
     * @ORM\Column(type="integer")
     * @var int
     */
    private $type = self::BONUS_TYPE;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $value = 0.0;

    /**
     * One of *_VALUE_TYPE constants.
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    private $value_type = self::NUMERIC_VALUE_TYPE;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTimeInterface
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function setRules(string $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValueType(): ?int
    {
        return $this->value_type;
    }

    public function setValueType(int $value_type): self
    {
        $this->value_type = $value_type;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }
}
