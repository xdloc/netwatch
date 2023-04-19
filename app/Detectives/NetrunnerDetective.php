<?php

namespace App\Detectives;

use App\Detectives\Data\NetrunnerData;
use App\Weapons\NetrunnerComparatorInterface;
use App\Weapons\NetrunnerExtractor;
use App\Weapons\NetrunnerPresserInterface;
use App\Weapons\NetrunnerSubmitterInterface;


class NetrunnerDetective extends Detective
{
    private NetrunnerData $detectiveData;

    /**
     * @param NetrunnerData $detectiveData
     */
    public function __construct(NetrunnerData $detectiveData)
    {
        $this->detectiveData = $detectiveData;
    }



    function click()
    {
        // TODO: Implement click() method.
    }

    function getClient()
    {
        // TODO: Implement getClient() method.
    }

    function setClient()
    {
        // TODO: Implement setClient() method.
    }
}
