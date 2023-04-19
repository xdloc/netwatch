<?php

namespace App\Models;

use App\ValueObjects\Evidence;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int police_id foreign key for Police
 * @property int suspect_id foreign key for Suspect
 * @property int verdict_id foreign key for Verdict
 * @property Evidence[] evidence array of all Evidence found by Investigation
 * @property CarbonImmutable created_at
 * @property CarbonImmutable updated_at
 *
 */
class Investigation extends Model
{
    use HasFactory;

    /**
     * @param Evidence $evidence
     */
    public function attachEvidence(Evidence $evidence)
    {
        $this->evidence[] = $evidence;
    }

    /**
     * @return Attribute
     */
    protected function evidence(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => json_decode($value,true),
            set: fn ($value) => json_encode($value)
        );
    }
}
