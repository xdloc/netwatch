<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;

class BankCode implements ValueObjectInterface
{
    private string $bankCode;

    /**
     * @param string $bankCode
     * @throws InconsistentValueObjectException
     */
    public function __construct(string $bankCode)
    {
        if (mb_strlen($bankCode) < 8) {
            throw new InconsistentValueObjectException('Bank code is too short', 400);
        }
        if (mb_strlen($bankCode) > 8) {
            throw new InconsistentValueObjectException('Bank code is too long', 400);
        }
        $this->bankCode = $bankCode;
    }

    public function __toString(): string
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getBankCode(): string
    {
        return $this->bankCode;
    }
}
