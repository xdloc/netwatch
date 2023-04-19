<?php

namespace App\Factories;

use App\ValueObjects\Bank;
use App\ValueObjects\BankCode;

class BankFactory
{
    public function createBank1(): Bank
    {
        return new Bank(new BankCode(''), '');
    }

    public function createBank2(): Bank
    {
        return new Bank(new BankCode(''), ''); //Точка Банк Киви Банк

    }

}
