<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;
use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

class Account implements ValueObjectInterface, Arrayable, \JsonSerializable
{
    private string $value;

    /**
     * @param string|int $account
     * @throws InconsistentValueObjectException
     */
    public function __construct(string|int $account)
    {
        if (mb_strlen((string)$account) < 20) {
            throw new InconsistentValueObjectException('Account number is too short', 400);
        }
        if (mb_strlen((string)$account) > 20) {
            throw new InconsistentValueObjectException('Account number is too long', 400);
        }
        $this->value = $account;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    #[Pure]
    public function isEqualTo(Account $account): bool
    {
        return $this->getValue() === $account->getValue();
    }

    /**
     * @inheritdoc
     */
    public function toArray(): int|array
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->value;
    }
}
