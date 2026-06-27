<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolTeam extends Model
{
    protected $table = 'school_teams';
    protected $fillable = [
        'school_id',
        'sport_id',
        'coach_teacher_id',
        'name',
        'icon_path'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'coach_teacher_id');
    }

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class, 'team_id');
    }
}
