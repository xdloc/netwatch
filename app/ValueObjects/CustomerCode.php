<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;

class CustomerCode implements CustomerCodeInterface, \JsonSerializable
{
    private string $value;

    /**
     * @param string|int $customerCode
     * @throws InconsistentValueObjectException
     */
    public function __construct(string|int $customerCode)
    {
        if (mb_strlen(trim((string)$customerCode)) < 9) {
            throw new InconsistentValueObjectException('Customer code is too short', 400, null, $this);
        }
        if (mb_strlen(trim((string)$customerCode)) > 9) {
            throw new InconsistentValueObjectException('Customer code is too long', 400, null, $this);
        }
        $this->value = (string)$customerCode;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isEqualTo(CustomerCode $customerCode): bool
    {
        return $this->value === (string)$customerCode;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->value;
    }
}
