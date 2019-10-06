<?php
declare(strict_types=1);

namespace App\Dto\Message;

use App\Entity\SalaryFactor;

/**
 * Represents a message indicating that a number of salary factors updated.
 */
class SalaryFactorUpdateMessage implements MessageInterface
{
    /**
     * @var int[]
     */
    private $factorIds = [];

    /**
     * @param SalaryFactor $factor
     * @return self
     */
    public function addFactor(SalaryFactor $factor): self
    {
        $this->factorIds[] = $factor->getId();
        return $this;
    }

    /**
     * @return int[]
     */
    public function getFactorIds(): array
    {
        return $this->factorIds;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return [
            'factor_ids' => $this->factorIds,
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
        $this->factorIds = $data['factor_ids'] ?? [];
    }
}
