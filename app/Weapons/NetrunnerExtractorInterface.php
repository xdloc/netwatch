<?php

namespace App\Weapons;

use App\Weapons\Clips\NetrunnerCredentialsExtractorClip;

interface NetrunnerExtractorInterface extends WeaponInterface
{
    /**
     * @param NetrunnerCredentialsExtractorClip $clip
     */
    public function __construct(NetrunnerCredentialsExtractorClip $clip);
}
