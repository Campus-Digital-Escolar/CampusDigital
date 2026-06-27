<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    protected $fillable = [
        'name',
        'icon_path',
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
}
