<?php

namespace App\ValueObjects;

use App\Exceptions\InconsistentValueObjectException;
use JetBrains\PhpStorm\Pure;

class StateRegistrationNumber implements ValueObjectInterface
{
    private string $ogrn;

    /**
     * @param string|int $ogrn
     * @throws InconsistentValueObjectException
     */
    public function __construct(string|int $ogrn)
    {
        if (mb_strlen((string)$ogrn) < 13) {
            throw new InconsistentValueObjectException('State registration number is too short', 400);
        }
        if (mb_strlen((string)$ogrn) > 13) {
            throw new InconsistentValueObjectException('State registration number is too long', 400);
        }
        $this->ogrn = $ogrn;
    }

    /**
     * @return string
     */
    public function getOgrn(): string
    {
        return $this->ogrn;
    }

    public function __toString(): string
    {
        return $this->ogrn;
    }

    #[Pure]
    public function isEqualTo(StateRegistrationNumber $ogrn): bool
    {
        return $this->getOgrn() === $ogrn->getOgrn();
    }
}
