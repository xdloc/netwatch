<?php

namespace App\Weapons;

use App\Weapons\Clips\NetrunnerCredentialsComparatorClip;
use JetBrains\PhpStorm\Pure;

class NetrunnerComparator extends Weapon implements WeaponInterface
{
    #[Pure]
    public function __construct(NetrunnerCredentialsComparatorClip $clip)
    {
        $this->clip = $clip;
        parent::__construct($clip);
    }

    public function execute(): bool
    {
        if ($this->clip instanceof NetrunnerCredentialsComparatorClip) {
            return $this->compareCredentials();
        }
    }

    private function compareCredentials(): bool
    {
        $nameFound = $taxCodeFound = $accountFound = $stateRegistrationNumberFound = false;

        if (str_contains($this->clip->getCredentialsString(), $this->clip->getLegalEntity()->getLegalEntityName())) {
            $nameFound = true;
        }
        if (str_contains($this->clip->getCredentialsString(), $this->clip->getLegalEntity()->getLegalEntityName())) {
            $taxCodeFound = true;
        }
        if (str_contains($this->clip->getCredentialsString(), $this->clip->getLegalEntity()->getLegalEntityName())) {
            $accountFound = true;
        }
        if (str_contains($this->clip->getCredentialsString(), $this->clip->getLegalEntity()->getLegalEntityName())) {
            $stateRegistrationNumberFound = true;
        }

        if (str_contains($this->clip->getCredentialsString(), 'ИП')
            || str_contains($this->clip->getCredentialsString(), 'Индивидуальный предприниматель')) {
            return $nameFound && $taxCodeFound && $accountFound;
        } else {
            return $nameFound && $taxCodeFound && $accountFound && $stateRegistrationNumberFound;
        }
    }
}
