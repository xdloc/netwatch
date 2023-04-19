<?php

namespace Tests\Feature;

use App\Models\Suspect;
use App\ValueObjects\Account;
use App\ValueObjects\LegalEntity;
use App\ValueObjects\TaxCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvestigateCredentialsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_console_command()
    {
        $customerCode = '300000741';
        $customer = ApiFacade::getCustomerFullInfo($customerCode);
        $accounts = ApiFacade::searchAccounts($customerCode);

        $account = '';

        foreach ($accounts as $acc) {
            if ($acc[0] . $acc[1] . $acc[2] === '474') {
                $account = $acc;
                break;
            }
        }

        $legalEntity = new LegalEntity(
            $customer->fullName, //'Индивидуальный предприниматель Галушка Максим Антонович',
            new TaxCode($customer->taxCode),
            new Account($account)
        );

        $suspect = Suspect::factory()
            ->hasHistory(1, [
                'legal_entity' => $legalEntity,
            ])
            ->create([
                'legal_entity' => $legalEntity,
            ]);

        $this->artisan('investigate:credentials')
            ->expectsQuestion('Please, enter customer code:', $customerCode)
            ->expectsOutput('Starting investigation...')
            ->assertSuccessful();
    }

}
