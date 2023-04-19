<?php

namespace App\Detectives\Data;

use App\Exceptions\InvalidDetectiveParam;

class DetectiveData implements DetectiveDataInterface
{
    /**
     * @throws InvalidDetectiveParam
     */
    public function __get(string $param)
    {
        if(isset($this->{$param})){
            return $this->{$param};
        } else throw new InvalidDetectiveParam('No such param: '.$param);
    }
}
