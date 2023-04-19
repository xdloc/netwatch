<?php

namespace App\Police;

use App\Detectives\DetectiveInterface;
use App\Interfaces\Involvable;
use App\Models\Investigation;
use App\Models\Suspect;
use App\Weapons\WeaponInterface;

/**
 * Interface to provide police department their functionality, responsible for investigation
 */
interface PoliceInterface
{
    /**
     * @return Investigation
     */
    public function investigate():Investigation;

    /**
     * @param Involvable $involvable
     */
    public function involve(Involvable $involvable): void;

    /**
     * @param Suspect $suspect
     */
    public function findSuspect(Suspect $suspect): void;

    /**
     * @return bool
     */
    public function hasSuspect(): bool;

    /**
     * @return Suspect
     */
    public function getSuspect(): Suspect;
}
