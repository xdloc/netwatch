<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property bool is_active
 * @property string name must be equal to App\Police\{name}Police
 */
class Police extends Model
{
    use HasFactory;
}
