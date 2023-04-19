<?php

namespace App\Detectives\Data;

/**
 * Params for detectives such as host, username, password etc based on detective functionality
 */
interface DetectiveDataInterface
{
    public function __get(string $param);
}
