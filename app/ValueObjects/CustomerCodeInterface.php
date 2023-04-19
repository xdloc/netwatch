<?php

namespace App\ValueObjects;

interface CustomerCodeInterface extends ValueObjectInterface
{
    public function __toString(): string;
}
