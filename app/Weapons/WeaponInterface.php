<?php

namespace App\Weapons;

use App\Interfaces\Involvable;
use App\ValueObjects\ExecutionInterface;

/**
 * Inherited weapon's name must be started from his owner detective
 */
interface WeaponInterface extends Involvable
{
    /**
     * @return mixed
     */
    public function execute(): mixed;
}
