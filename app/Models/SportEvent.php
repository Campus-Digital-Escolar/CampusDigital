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
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(SportStage::class, 'stage_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function scopeOfSport($query, $sportId)
    {
        return $query->where('sport_id', $sportId);
    }
}
