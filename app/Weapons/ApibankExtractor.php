<?php

namespace App\Weapons;

use App\Weapons\Clips\ApibankExtractorClip;
use JetBrains\PhpStorm\Pure;

class ApiExtractor extends Weapon implements WeaponInterface
{
    /**
     * @inheritDoc
     */
    #[Pure]
    public function execute(): ApiFacade
    {
        return new ApiFacade();
    }
}
