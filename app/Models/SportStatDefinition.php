<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SportStatDefinition extends Model
{
    protected $table = 'sport_stat_definitions';
    protected $fillable = [
        'sport_id',
        'name',
        'data_type'
    ];
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }
}
