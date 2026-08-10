<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosition extends Model
{
    protected $fillable = [
        'name',
        'department',
    ];

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }
}
