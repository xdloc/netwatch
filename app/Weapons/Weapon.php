<?php

namespace App\Weapons;

use App\Assistants\ClassAssistant;
use App\Detectives\DetectiveInterface;
use App\ValueObjects\ExecutionInterface;
use App\Weapons\Clips\ClipInterface;

abstract class Weapon implements WeaponInterface
{
    protected ClipInterface $clip;
    protected DetectiveInterface $detective;

    /**
     * @param ClipInterface $clip
     */
    public function __construct(ClipInterface $clip)
    {
        $this->clip = $clip;
    }

    /**
     * @return mixed
     */
    public function __invoke(): mixed
    {
        $this->detective = $this->findDetective();
        return $this->execute();
    }

    /**
     * @return DetectiveInterface
     */
    private function findDetective():DetectiveInterface
    {
        $detectiveClassname = ClassAssistant::getDetective(static::class);
        return new $detectiveClassname;
    }
}
