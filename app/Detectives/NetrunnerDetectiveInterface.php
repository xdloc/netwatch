<?php

namespace App\Detectives;

use App\Detectives\Data\DetectiveDataInterface;
use App\Detectives\Data\NetrunnerData;

interface NetrunnerDetectiveInterface extends DetectiveInterface
{
    public function __construct(NetrunnerData $detectiveData);

    function click();

    function getClient();

    function setClient();

}
