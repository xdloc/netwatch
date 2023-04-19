<?php

namespace App\Police;

use App\Exceptions\InvestigationFailedException;
use App\ValueObjects\CustomerCodeInterface;

/**
 * Police Builder Director
 */
class NineOneOneOperator implements NineOneOneOperatorInterface
{
    /**
     * @param PoliceAssemblerInterface $policeAssembler
     * @param CustomerCodeInterface $customerCode
     * @return PoliceInterface
     * @throws InvestigationFailedException
     */
    public function assemble(PoliceAssemblerInterface $policeAssembler, CustomerCodeInterface $customerCode): PoliceInterface
    {
        try {
            $policeAssembler->initiatePolice();
            $policeAssembler->findSuspect($customerCode);
        } catch (\Exception $exception) {
            throw new InvestigationFailedException('Investigation failed', 503, $exception);
        }
        return $policeAssembler->getPolice();
    }
}
