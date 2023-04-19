<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;
use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

class TaxCode implements ValueObjectInterface, Arrayable, \JsonSerializable
{
    private string $value;

    /**
     * @param string $taxCode
     * @throws InconsistentValueObjectException
     */
    public function __construct(string $taxCode)
    {
        if (mb_strlen($taxCode) < 10) {
            throw new InconsistentValueObjectException('Tax code is too short', 400);
        }
        if (mb_strlen($taxCode) > 12) {
            throw new InconsistentValueObjectException('Tax code is too short', 400);
        }

        $this->value = $taxCode;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    #[Pure]
    public function isEqualTo(TaxCode $taxCode): bool
    {
        return $this->getValue() === $taxCode->getValue();
    }

    /**
     * @inheritdoc
     */
    #[Pure]
    public function toArray(): array|string
    {
        return $this->getValue();
    }

    /**
     * @inheritdoc
     */
    #[Pure]
    public function jsonSerialize(): string
    {
        return $this->getValue();
    }
}
