<?php

namespace App\Detectives;

use App\Assistants\ClassAssistant;

abstract class Detective implements DetectiveInterface
{
    public function extract(ClipInterface $clip)
    {
        $this->getWeapon(ClassAssistant::getWeapons(static::class));
        //$extractor = new {DETECTIVE_EXTRACT_OR};
        //$extractor->execute(params);
}
}
