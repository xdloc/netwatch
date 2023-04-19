<?php

namespace App\Police;

use App\Models\Suspect;
use App\ValueObjects\CustomerCodeInterface;

class CredentialsPoliceAssembler implements PoliceAssemblerInterface
{
    private ?CredentialsPolice $credentialsPolice = null;

    public function initiatePolice(): void
    {
        $this->credentialsPolice = new CredentialsPolice();
    }

    public function findSuspect(CustomerCodeInterface $customerCode): void
    {
        $this->credentialsPolice->involve(Suspect::byCustomerCode($customerCode)->firstOrNew());
    }

    /**
     * @return PoliceInterface
     */
    public function getPolice(): PoliceInterface
    {
        return $this->credentialsPolice;
    }
}
