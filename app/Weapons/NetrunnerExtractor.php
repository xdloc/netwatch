<?php

namespace App\Weapons;

use App\ValueObjects\Account;
use App\ValueObjects\StateRegistrationNumber;
use App\ValueObjects\TaxCode;
use App\Weapons\Clips\NetrunnerCredentialsExtractorClip;
use App\Weapons\Clips\NetrunnerExtractorClipInterface;
use JetBrains\PhpStorm\Pure;

class NetrunnerExtractor extends Weapon implements NetrunnerExtractorInterface
{
    #[Pure]
    public function __construct(NetrunnerExtractorClipInterface $clip)
    {
        $this->clip = $clip;
        parent::__construct($clip);
    }

    /**
     * todo make it automatic based on clip interface
     * @inheritdoc
     */
    public function execute(): string
    {
        if ($this->clip instanceof NetrunnerCredentialsExtractorClip) {
            return $this->extractCredentials();
        }
        // go to website url,
        // get page,
        // parse it,
        // find credentials or do not find it and Credentials VO for it
    }

    /**
     * @return string
     */
    private function extractCredentials(): string
    {
        $extractedData = [];
        $this->clip->getCrawler()->filter($this->clip->getCredentialsDom())->each(function ($node) {
            $extractedData[] = $node->text();
        });
        //$parsedData = [];
        $parsedString = '';
        //todo it puts it in one row, not in array (as I seen)
        foreach ($extractedData as $datum) {
            if (is_string($datum) || is_integer($datum)) {
                $parsedString .= $datum;
            }
            /*            if ($value = $this->detectValueObject($datum) !== null) {
                            $parsedData[$value] = new $value($datum);
                        } else {
                            $parsedData['strings'][] = $datum;
                        }*/
        }
        return $parsedString;

        /*$legalEntities = [];
        foreach ($parsedData['strings'] as $string) {
            $legalEntities[] = new LegalEntity(
                $string,
                $parsedData[TaxCode::class],
                $parsedData[Account::class],
                $parsedData[StateRegistrationNumber::class]);
        }
        // return array of possible credentials to compare with because it can contain a lot of strings, not only 1
        return $legalEntities;*/
    }

    /**
     * @param mixed $datum
     * @return string|null
     */
    private function detectValueObject(mixed $datum): ?string
    {
        $detector = new Detector($datum);
        if ($detector->isTaxCode()) {
            return TaxCode::class;
        }
        if ($detector->isStateRegistrationNumber()) {
            return StateRegistrationNumber::class;
        }
        if ($detector->isAccount()) {
            return Account::class;
        }
        return null;
    }
}
