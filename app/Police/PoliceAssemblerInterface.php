<?php

namespace App\Police;


use App\ValueObjects\CustomerCodeInterface;

interface PoliceAssemblerInterface
{
    public function initiatePolice(): void;

    public function findSuspect(CustomerCodeInterface $customerCode): void;

    public function getPolice(): PoliceInterface;
}
