<?php

namespace App\Models;

use App\Exceptions\InconsistentValueObjectException;
use App\Interfaces\Involvable;
use App\ValueObjects\Account;
use App\ValueObjects\Bank;
use App\ValueObjects\BankCode;
use App\ValueObjects\CorrespondentAccount;
use App\ValueObjects\Credentials;
use App\ValueObjects\CustomerCode;
use App\ValueObjects\LegalEntity;
use App\ValueObjects\TaxCode;
use App\ValueObjects\WebsiteURL;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder|self byCustomerCode(CustomerCode $customerCode)
 * @uses \App\Models\Suspect::scopeByCustomerCode()
 *
 * @mixin Builder
 * @mixin Collection
 *
 * @property int id
 * @property CustomerCode customer_code
 * @property LegalEntity legal_entity
 * @property Bank bank
 * @property CorrespondentAccount corresponding_account
 * @property WebsiteURL website_url
 * @property WebsiteURL website_credentials_url
 * @property string credentials_dom
 * @property CarbonImmutable created_at
 * @property CarbonImmutable updated_at
 *
 * @property SuspectHistory[] history
 */
class Suspect extends Model implements Involvable
{
    use HasFactory;

    /**
     * @param Builder $query
     * @param CustomerCode $customerCode
     * @return Builder
     */
    public function scopeByCustomerCode(Builder $query, CustomerCode $customerCode): Builder
    {
        return $query->where('customer_code', '=', (string)$customerCode);
    }

    /**
     * @param WebsiteURL $url
     */
    public function setUrl(WebsiteURL $url): void
    {
        if ($url->getPage() === WebsiteURL::PAGE_MAIN) {
            $page = '_';
        } else {
            $page = '_' . $url->getPage() . '_';
        }
        $websiteUrlProperty = 'website' . mb_strtolower($page) . 'url';
        $this->{$websiteUrlProperty} = $url->getValue();
    }

    /**
     * @param string $page
     * @return mixed
     * @throws InconsistentValueObjectException
     */
    public function getUrl(string $page): string
    {
        $websiteUrl = new WebsiteURL(WebsiteURL::DUMMY_URL, $page);
        if ($websiteUrl->getPage() === WebsiteURL::PAGE_MAIN) {
            $page = '_';
        } else {
            $page = '_' . $page . '_';
        }
        return $this->{$page};
    }

    /**
     * @return Attribute
     */
    protected function customerCode(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new CustomerCode($value),
        );
    }

    /**
     * @return Attribute
     */
    protected function legalEntity(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => new LegalEntity(
                $attributes['legal_entity_name'],
                $attributes['tax_code'],
                $attributes['account'],
            ),
        );
    }

    /**
     * @return Attribute
     */
    protected function bank(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => new Bank(
                $attributes['bank_code'],
                $attributes['bank_name']
            ),
        );
    }

    /**
     * @return Attribute
     */
    protected function correspondentAccount(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => new CorrespondentAccount(
                new Bank(new BankCode($attributes['bank_code']), $attributes['bank_name']),
                new Account($attributes['correspondent_account'])
            ),
        );
    }

    /**
     * @return Attribute
     */
    protected function credentials(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => new Credentials(
                new LegalEntity(
                    $attributes['legal_entity_name'],
                    new TaxCode($attributes['tax_code']),
                    new Account($attributes['account'])
                ),
                new Bank(
                    new BankCode($attributes['bank_code']), $attributes['bank_name']
                ),
                new CorrespondentAccount(
                    new Bank(
                        new BankCode($attributes['bank_code']), $attributes['bank_name']
                    ),
                    new Account($attributes['correspondent_account']))
            )
        );
    }


    /**
     * @return Attribute
     */
    protected function websiteUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new WebsiteURL($value, WebsiteURL::PAGE_MAIN),
        );
    }

    /**
     * @return Attribute
     */
    protected function websiteCredentialsUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new WebsiteURL($value, WebsiteURL::PAGE_CREDENTIALS),
        );
    }

    /**
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new CarbonImmutable($value, new \DateTimeZone(env('APP_TIMEZONE', 'Asia/Yekaterinburg'))),
        );
    }

    /**
     * @return Attribute
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new CarbonImmutable($value, new \DateTimeZone(env('APP_TIMEZONE', 'Asia/Yekaterinburg'))),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SuspectHistory::class);
    }
}
