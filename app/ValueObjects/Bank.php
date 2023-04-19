<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Bank implements ValueObjectInterface, Arrayable, \JsonSerializable
{
    private BankCode $bank_code;
    private string $bank_name;

    /**
     * @param BankCode $bank_code
     * @param string $bank_name
     */
    public function __construct(
        BankCode $bank_code,
        string   $bank_name
    )
    {
        $this->bank_code = $bank_code;
        $this->bank_name = $bank_name;
    }

    /**
     * @return BankCode
     */
    public function getBankCode(): BankCode
    {
        return $this->bank_code;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->bank_name;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getBankName() . ' ' . $this->getBankCode();
    }

    #[Pure]
    public function isEqualTo(Bank $bank): bool
    {
        return $this->getBankCode() === $bank->getBankCode()
            && $this->getBankName() === $bank->getBankName();
    }

    /**
     * @inheritdoc
     */
    #[Pure]
    #[ArrayShape([
        'bank_code' => "string",
        'bank_name' => "string"
    ])]
    public function toArray(): array
    {
        return [
            'bank_code' => (string)$this->getBankCode(),
            'bank_name' => $this->getBankName()
        ];
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }
}
