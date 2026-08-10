<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    protected $fillable = [
        'name',
        'category',
        'icon_path',
        'rules',
        'status'
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(SchoolTeam::class);
    }

    public function sportEvents(): HasMany
    {
        return $this->hasMany(SportEvent::class);
    }

    public function statDefinitions(): HasMany
    {
        return $this->hasMany(SportStatDefinition::class);
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_sport', 'sport_id', 'school_id')
            ->withPivot('active');
    }
}
