<?php

namespace App\Weapons\Clips;

use App\ValueObjects\LegalEntity;

class NetrunnerCredentialsComparatorClip implements ClipInterface
{
    private string $credentialsString;
    private LegalEntity $legalEntity;

    /**
     * @param string $credentialsString
     * @param LegalEntity $legalEntity
     */
    public function __construct(string $credentialsString, LegalEntity $legalEntity)
    {
        $this->credentialsString = $credentialsString;
        $this->legalEntity = $legalEntity;
    }

    /**
     * @return string
     */
    public function getCredentialsString(): string
    {
        return $this->credentialsString;
    }

    /**
     * @return LegalEntity
     */
    public function getLegalEntity(): LegalEntity
    {
        return $this->legalEntity;
    }
}
