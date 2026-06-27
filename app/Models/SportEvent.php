<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SportEvent extends Model
{
    protected $table = 'sport_events';
    protected $fillable = [
        'school_id',
        'sport_id',
        'parent_event_id',
        'educational_level_id',
        'stage_id',
        'event_date',
        'is_live',
        'status'
    ];
    protected $casts = [
        'event_date' => 'datetime',
        'is_live' => 'boolean'
    ];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(SportStage::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class, 'event_id');
    }
}
