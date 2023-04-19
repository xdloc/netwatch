<?php

namespace App\Police;

use App\Detectives\DetectiveInterface;
use App\ValueObjects\CustomerCodeInterface;

/**
 * 911. Police Builder Director
 */
interface NineOneOneOperatorInterface
{
    public function assemble(PoliceAssemblerInterface $policeAssembler, CustomerCodeInterface $customerCode): PoliceInterface;
}
