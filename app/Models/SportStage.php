<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SportStage extends Model
{
    protected $table = 'sport_stages';
    protected $fillable = ['name'];

    public function sportEvents(): HasMany
    {
        return $this->hasMany(SportEvent::class, 'stage_id');
    }
}
