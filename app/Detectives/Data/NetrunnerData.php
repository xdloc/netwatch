<?php

namespace App\Detectives\Data;

use App\ValueObjects\WebsiteURL;

class NetrunnerData extends DetectiveData
{
    private ?WebsiteURL $website = null;

    /**
     * @param WebsiteURL $website
     */
    public function __construct(
        WebsiteURL $website
    )
    {
        $this->website = $website;
    }
}
