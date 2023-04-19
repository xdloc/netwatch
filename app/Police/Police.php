<?php

namespace App\Police;

use App\Detectives\DetectiveInterface;
use App\Interfaces\Involvable;
use App\Models\Suspect;
use App\Weapons\WeaponInterface;

abstract class Police implements PoliceInterface
{
    /**
     * @var WeaponInterface[]
     */
    protected array $weapons = [];

    /**
     * @var DetectiveInterface[]
     */
    protected array $detectives = [];

    /**
     * @var Suspect
     */
    protected Suspect $suspect;

    /**
     * @inheritdoc
     */
    public function involve(Involvable $involvable): void
    {
        /*if ($involvable instanceof WeaponInterface) {
            $this->attachWeapon($involvable);
        }
        if ($involvable instanceof DetectiveInterface) {
            $this->engageDetective($involvable);
        }*/
        if ($involvable instanceof Suspect) {
            $this->findSuspect($involvable);
        }
    }

    /**
     * @inheritdoc
     */
    public function findSuspect(Suspect $suspect): void
    {
        $this->suspect = $suspect;
    }

    /**
     * @inheritdoc
     */
    public function hasSuspect(): bool
    {
        return (bool)$this->suspect;
    }

    /**
     * @inheritdoc
     */
    public function getSuspect(): Suspect
    {
        return $this->suspect;
    }
}
