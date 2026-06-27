<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = [
        'name',
        'campus',
        'address',
        'logo_path'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(SchoolTeam::class);
    }

    public function schoolPeriods(): HasMany
    {
        return $this->hasMany(SchoolPeriod::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'school_subject');
    }

    public function sports(): BelongsToMany
    {
        return $this->belongsToMany(Sport::class, 'school_sport')->withPivot('active');
    }
}
