<?php

namespace App\Police;

use App\Detectives\ApiDetectiveInterface;
use App\Models\Investigation;
use App\ValueObjects\Account;
use App\ValueObjects\Evidence;
use App\ValueObjects\HttpMethod;
use App\ValueObjects\LegalEntity;
use App\ValueObjects\StateRegistrationNumber;
use App\Weapons\Clips\NetrunnerCredentialsComparatorClip;
use App\Weapons\Clips\NetrunnerCredentialsExtractorClip;
use App\Weapons\Clips\NetrunnerScannerClip;
use App\Weapons\NetrunnerComparator;
use App\Weapons\NetrunnerExtractor;
use App\Weapons\NetrunnerScanner;
use Illuminate\Support\Facades\Cache;

class CredentialsPolice extends Police
{
/*    private ApibankDetectiveInterface $apibankDetective;

    public function __construct(ApibankDetectiveInterface $apibankDetective)
    {
        $this->apibankDetective = $apibankDetective;
    }*/

    public function investigate(): Investigation
    {
        //$apiExtractor = new ApibankExtractor(new ApibankExtractorClip()); todo

        // foreach all legal entities with shortName and fullName, also with each account
        // save to history every change, not everytime
        // if we have no history and saving it for the first time - save account with check we just have this number
        // but for second and other times - need to check it by history, not by all account list
        // also we can do that for all others credentials, but maybe with fewer alerts
        // we can do warnings also and can do critical warnings, then changes something not important or crucial
        [$customer, $names, $accounts, $stateRegistrationNumber, $banks] = $this->getCustomerData();
        $legalEntities = [];

        foreach ($names as $name) {
            foreach ($accounts as $account) {
                $legalEntities[] = new LegalEntity(
                    $name,
                    $customer->taxCode,
                    new Account($account),
                    new StateRegistrationNumber($stateRegistrationNumber)
                );
            }
        }

        // scanner
        $scanner = new NetrunnerScanner(
            new NetrunnerScannerClip($this->suspect->website_credentials_url, new HttpMethod('GET')
            )
        );

        //todo extract it once, compare later
        $extractor = new NetrunnerExtractor(
            new NetrunnerCredentialsExtractorClip(($scanner)(),
                $this->suspect->credentials_dom)
        );

        $credentialsString = ($extractor)();

        $equalityFound = false;
        $correctLegalEntity = '';

        foreach ($legalEntities as $legalEntity) {
            $comparator = new NetrunnerComparator(
                new NetrunnerCredentialsComparatorClip($credentialsString, $legalEntity)
            );
            if ($comparator() === true) {
                $equalityFound = true;
                $correctLegalEntity = $legalEntity;
                break;
            }
        }
        $evidenceParams = [];
        $evidenceParams[Evidence::RAW_CREDENTIALS] = $credentialsString;
        if ($equalityFound) {
            $evidenceParams[Evidence::LEGAL_ENTITY] = $correctLegalEntity;
            $evidenceParams[Evidence::PASSED] = true;
        }

        $evidence = new Evidence($evidenceParams);

        $investigation = new Investigation();
        $investigation->attachEvidence($evidence);
    }

    /**
     * @return array
     */
    private function getCustomerData(): array
    {
        $customer = $this->getCustomer();
        $names = $this->getNames($customer);
        $accounts = $this->getAccounts();
        $stateRegistrationNumber = $this->getStateRegistrationNumber($customer);
        $banks = $this->getBanks($accounts);
        return [$customer, $names, $accounts, $stateRegistrationNumber, $banks];
    }

    /**
     * {
     * }
     * @return CustomerFull
     */
    private function getCustomer(): CustomerFull
    {
        //return $this->apibankDetective->getCustomerFullInfo($this->suspect->customer_code);
        return ApibankFacade::getCustomerFullInfo($this->suspect->customer_code); //todo , ['REGISTRATION_DOCUMENTS']
    }

    /**
     * [
     * "shortName": "ООО \"НТФАРМА\"",
     * "fullName": "Общество с ограниченной ответственностью \"НТФАРМА\""
     * ]
     * @param CustomerFull $customer
     * @return array
     */
    private function getNames(CustomerFull $customer): array
    {
        return [$customer->shortName, $customer->fullName];
    }

    /**
     * [{
     * }]
     * @return array|null
     */
    private function getAccounts(): ?array
    {
        //return $this->apibankDetective->searchAccounts($this->suspect->customer_code);
        return ApibankFacade::searchAccounts($this->suspect->customer_code);
    }

    /**
     * @param CustomerFull $customer
     * @return string|null
     */
    private function getStateRegistrationNumber(CustomerFull $customer): ?string
    {
        $ogrn = null;
        foreach ($customer->registrationDocuments as $document) {
            if ($document->type == 5) {
                $ogrn = $document->number;
            }
        }
        return $ogrn;
    }

    /**
     *
     * @param array $accounts
     * @return array
     */
    private function getBanks(array $accounts): array
    {
        return []; // not required right now
        if (Cache::has('banks')) {
            return Cache::get('banks');
        } else {
            $banks = [];
            foreach ($accounts as $account) {
                $bank[$account->bankCode] = ApibankFacade::cache(1)->bank($account->bankCode);
            }
            Cache::put('banks', $banks, 60);
        }

        return $banks;
    }
}
