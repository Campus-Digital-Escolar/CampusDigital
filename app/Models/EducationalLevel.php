<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationalLevel extends Model
{
    protected $table = 'educational_levels';
    protected $fillable = [
        'name',
        'slug'
    ];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
