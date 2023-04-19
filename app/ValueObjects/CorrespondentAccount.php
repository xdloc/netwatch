<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\Pure;

class CorrespondentAccount implements ValueObjectInterface, Arrayable, \JsonSerializable
{
    private Bank $bank;
    private Account $correspondentAccount;

    /**
     * @param Bank $bank
     * @param Account $correspondentAccount
     */
    public function __construct(Bank $bank, Account $correspondentAccount)
    {

        $this->bank = $bank;
        $this->correspondentAccount = $correspondentAccount;
    }

    /**
     * @return Bank
     */
    public function getBank(): Bank
    {
        return $this->bank;
    }

    /**
     * @return Account
     */
    public function getCorrespondentAccount(): Account
    {
        return $this->correspondentAccount;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getCorrespondentAccount();
    }

    /**
     * @param CorrespondentAccount $correspondentAccount
     * @return bool
     */
    #[Pure]
    public function isEqualTo(CorrespondentAccount $correspondentAccount): bool
    {
        return $this->bank->isEqualTo($correspondentAccount->getBank())
            && $this->getCorrespondentAccount()->isEqualTo($correspondentAccount->getCorrespondentAccount());

    }

    /**
     * @inheritdoc
     */
    public function toArray(): array|string
    {
        return (string)$this->correspondentAccount;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return (string)$this->correspondentAccount;
    }
}
