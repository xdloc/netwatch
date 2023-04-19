<?php

namespace App\PoliceCalls;

/**
 * Police Job
 */
interface PoliceCallInterface
{
    public function __construct();

    public function handle();
}
