<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Credentials implements CredentialsInterface, Arrayable, \JsonSerializable
{
    private LegalEntity $legalEntity;
    private Bank $bank;
    private CorrespondentAccount $correspondentAccount;

    /**
     * @param LegalEntity $legalEntity
     * @param Bank $bank
     * @param CorrespondentAccount $correspondentAccount
     */
    public function __construct(
        LegalEntity          $legalEntity,
        Bank                 $bank,
        CorrespondentAccount $correspondentAccount
    )
    {
        $this->legalEntity = $legalEntity;
        $this->bank = $bank;
        $this->correspondentAccount = $correspondentAccount;
    }

    /**
     * @return LegalEntity
     */
    public function getLegalEntity(): LegalEntity
    {
        return $this->legalEntity;
    }

    /**
     * @return Bank
     */
    public function getBank(): Bank
    {
        return $this->bank;
    }

    /**
     * @return CorrespondentAccount
     */
    public function getCorrespondentAccount(): CorrespondentAccount
    {
        return $this->correspondentAccount;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->getLegalEntity() . ' ' . $this->getCorrespondentAccount();
    }

    /**
     * @param Credentials $credentials
     * @return bool
     */
    #[Pure]
    public function isEqualTo(Credentials $credentials): bool
    {
        return
            $this->getBank()->isEqualTo($credentials->getBank())
            &&
            $this->getCorrespondentAccount()->isEqualTo($credentials->getCorrespondentAccount())
            &&
            $this->getLegalEntity()->isEqualTo($credentials->getLegalEntity());
    }

    /**
     * @inheritdoc
     */
    #[Pure]
    #[ArrayShape([
        'legal_entity' => "array|string[]",
        'bank' => "array",
        'correspondent_account' => "string",
    ])]
    public function toArray(): array
    {
        return [
            'bank' => $this->getBank()->toArray(),
            'correspondent_account' => (string)$this->getCorrespondentAccount(),
            'legal_entity' => $this->getLegalEntity()->toArray()
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
