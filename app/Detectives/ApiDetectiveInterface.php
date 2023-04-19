<?php

namespace App\Detectives;

use App\ValueObjects\CustomerCode;

interface ApiDetectiveInterface extends DetectiveInterface
{
    public function getCustomerFullInfo(CustomerCode $customerCode);

    public function searchAccounts(CustomerCode $customerCode);
}
