<?php

namespace Database\Factories;

use App\Factories\BankFactory;
use App\ValueObjects\Account;
use App\ValueObjects\CorrespondentAccount;
use App\ValueObjects\LegalEntity;
use App\ValueObjects\TaxCode;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suspect>
 */
class SuspectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_code' => '300000000',//fake()->name(),
            'legal_entity' => new LegalEntity(fake()->name, new TaxCode('1234567890'), new Account('40000000000000000000')),//fake()->unique()->safeEmail(),
            'bank' => (new BankFactory())->createBank1(),
            'corresponding_account' => new CorrespondentAccount((new BankFactory())->createBank1(), new Account('40000000000000000000')),
            'website_url' => env('APP_URL') . '/test/',
            'website_credentials_url' => env('APP_URL') . '/test/credentials.php',
            'credentials_dom' => 'footer > div.credentials',
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now(),
        ];
    }
}
