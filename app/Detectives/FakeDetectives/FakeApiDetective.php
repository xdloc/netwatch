<?php

namespace App\Detectives\FakeDetectives;

use App\ValueObjects\CustomerCode;

class FakeApiDetective implements \App\Detectives\ApiDetectiveInterface
{

    public function getCustomerFullInfo(CustomerCode $customerCode)
    {
        // TODO: Implement getCustomerFullInfo() method.
    }

    public function searchAccounts(CustomerCode $customerCode)
    {
        // TODO: Implement searchAccounts() method.
    }
}
