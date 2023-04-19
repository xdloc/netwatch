<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class LegalEntity implements ValueObjectInterface, Arrayable, \JsonSerializable
{
    private string $legalEntityName;
    private TaxCode $taxCode;
    private Account $account;
    private StateRegistrationNumber $ogrn;

    /**
     * @param string $legalEntityName
     * @param TaxCode $taxCode
     * @param Account $account
     * @param StateRegistrationNumber|null $ogrn
     */
    public function __construct(
        string                   $legalEntityName,
        TaxCode                  $taxCode,
        Account                  $account,
        ?StateRegistrationNumber $ogrn = null
    )
    {
        $this->legalEntityName = $legalEntityName;
        $this->taxCode = $taxCode;
        $this->account = $account;
        $this->ogrn = $ogrn;
    }

    /**
     * @return string
     */
    public function getLegalEntityName(): string
    {
        return $this->legalEntityName;
    }

    /**
     * @return TaxCode
     */
    public function getTaxCode(): TaxCode
    {
        return $this->taxCode;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getLegalEntityName() . ' ' . $this->getTaxCode() . ' ' . $this->getAccount().' '.$this->getOgrn();
    }

    /**
     * @param LegalEntity $legalEntity
     * @return bool
     */
    #[Pure] public function isEqualTo(LegalEntity $legalEntity): bool
    {
        return $this->getLegalEntityName() === $legalEntity->getLegalEntityName()
            && $this->getTaxCode()->isEqualTo($legalEntity->getTaxCode())
            && $this->getAccount()->isEqualTo($legalEntity->getAccount())
            && $this->getOgrn()->isEqualTo($legalEntity->getOgrn());
    }

    /**
     * @inheritdoc
     */

    #[Pure]
    #[ArrayShape([
        'legal_entity_name' => "string",
        'tax_code' => "string",
        'account' => "string",
        'ogrn' => "string"
    ])]
    public function toArray(): array
    {
        return [
            'legal_entity_name' => $this->getLegalEntityName(),
            'tax_code' => (string)$this->getTaxCode(),
            'account' => (string)$this->getAccount(),
            'ogrn' => (string)$this->getOgrn()
        ];
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @return ?StateRegistrationNumber
     */
    public function getOgrn(): ?StateRegistrationNumber
    {
        return $this->ogrn;
    }
}
